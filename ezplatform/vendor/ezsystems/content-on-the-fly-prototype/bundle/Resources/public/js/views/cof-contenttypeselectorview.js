/*
 * Copyright (C) eZ Systems AS. All rights reserved.
 * For full copyright and license information view LICENSE file distributed with this source code.
 */
YUI.add('cof-contenttypeselectorview', function (Y) {
    'use strict';

    /**
     * Provides the Content Creation Widget Content Type Selector View class
     *
     * @module cof-contenttypeselectorview
     */
    Y.namespace('cof');

    var CLASS_HIDDEN = 'cof-is-hidden',
        CLASS_INVISIBLE = 'cof-invisible',
        CLASS_TOOLTIP_ERROR = 'cof-content-creation__tooltip--error',
        SELECTOR_ITEM_SELECTED = '.ez-selection-filter-item-selected',
        SELECTOR_CONTENT_TYPE_LIST = '.ez-contenttypeselector-list',
        SELECTOR_TOOLTIP = '.cof-content-creation__tooltip',
        ATTR_ID = 'data-id',
        ATTR_DESCRIPTION = 'data-description',
        PX = 'px',
        SCROLL_TIMEOUT = 100;

    /**
     * The Content Creation Widget Content Type Selector view
     *
     * @namespace cof
     * @class ContentTypeSelectorView
     * @constructor
     * @extends eZ.ContentTypeSelectorView
     */
    Y.cof.ContentTypeSelectorView = Y.Base.create('ContentTypeSelectorView', Y.eZ.ContentTypeSelectorView, [], {
        initializer: function () {
            this._scrollContentTypeHandler = null;
            this._correctTooltipPositionTimeout = null;

            this.get('container').addClass(this._generateViewClassName(Y.eZ.ContentTypeSelectorView.NAME));

            this.after('filterViewChange', this._attachOnSelectEventListener, this);
        },

        /**
         * Attach event listener on select.
         *
         * @protected
         * @method _attachOnSelectEventListener
         */
        _attachOnSelectEventListener: function () {
            this.get('filterView').on('select', this._addDescriptionToSelectedItem, this);
        },

        /**
         * Adds the description to the selected item.
         *
         * @protected
         * @method _addDescriptionToSelectedItem
         * @param event {Object} event facade
         */
        _addDescriptionToSelectedItem: function (event) {
            var contentTypeItem = event.elementNode,
                contentTypeItemId = contentTypeItem.getAttribute(ATTR_ID),
                contentTypeGroups = this.get('contentTypeGroups');

            contentTypeGroups.forEach(function (contentTypeGroup) {
                contentTypeGroup.get('contentTypes').forEach(function (contentType) {
                    if (contentTypeItemId === contentType.get('id')) {
                        var description = contentType.get('descriptions')[contentType.get('mainLanguageCode')];

                        if (description) {
                            contentTypeItem.setAttribute(ATTR_DESCRIPTION, description);
                        }
                    }
                });
            });

            /**
             * Informs an item is selected.
             * Listened in the cof.ContentCreationView
             *
             * @event itemSelected
             * @param text {String} text to show on remove button
             */
            this.fire('itemSelected', {text: event.text});

            this._correctTooltipPosition();
        },

        /**
         * Shows the tooltip.
         *
         * @method showTooltip
         */
        showTooltip: function () {
            this._toggleTooltip(true);

            this._setCorrectTooltipPositionOnScroll();
        },

        /**
         * Hides the tooltip.
         *
         * @method hideTooltip
         */
        hideTooltip: function () {
            this._toggleTooltip(false);

            if (this._scrollContentTypeHandler) {
                this._scrollContentTypeHandler.detach();
            }
        },

        /**
         * Toggle visibility of the tooltip.
         *
         * @protected
         * @method _toggleTooltip
         * @param show {Boolean} should show the tooltip?
         */
        _toggleTooltip: function (show) {
            var container = this.get('container'),
                selectedItem = container.one(SELECTOR_ITEM_SELECTED),
                tooltip = container.one(SELECTOR_TOOLTIP),
                methodName,
                description;

            if (!selectedItem) {
                return;
            }

            description = selectedItem.getAttribute(ATTR_DESCRIPTION);
            methodName = show && !!description ? 'removeClass' : 'addClass';

            tooltip.setHTML(description);

            tooltip[methodName](CLASS_HIDDEN);
            tooltip.removeClass(CLASS_TOOLTIP_ERROR);
        },

        /**
         * Sets detected content type scroll position event handler to manage the tooltip position.
         *
         * @protected
         * @method _setCorrectTooltipPositionOnScroll
         */
        _setCorrectTooltipPositionOnScroll: function () {
            this._scrollContentTypeHandler = this.get('container').one(SELECTOR_CONTENT_TYPE_LIST).on('scroll', Y.bind(this._setCorrectTooltipPositionTimeout, this));
        },

        /**
         * Sets the timeout on correct timeout position.
         * @protected
         * @method _setCorrectTooltipPositionTimeout
         */
        _setCorrectTooltipPositionTimeout: function () {
            window.clearTimeout(this._correctTooltipPositionTimeout);

            this._correctTooltipPositionTimeout = window.setTimeout(Y.bind(this._correctTooltipPosition, this), SCROLL_TIMEOUT);
        },
        /**
         * Corrects the tooltip position.
         *
         * @protected
         * @method _correctTooltipPosition
         */
        _correctTooltipPosition: function () {
            var container = this.get('container'),
                selectedItem = container.one(SELECTOR_ITEM_SELECTED),
                selectedItemRect,
                contentTypeListRect = container.one(SELECTOR_CONTENT_TYPE_LIST).getDOMNode().getBoundingClientRect(),
                tooltipSpace = 40,
                tooltip = container.one(SELECTOR_TOOLTIP);

            if (!selectedItem) {
                return;
            }

            selectedItemRect = selectedItem.getDOMNode().getBoundingClientRect();

            if (selectedItemRect.top < contentTypeListRect.top || selectedItemRect.top > contentTypeListRect.top + contentTypeListRect.height) {
                tooltip.addClass(CLASS_INVISIBLE);
            } else {
                tooltip.removeClass(CLASS_INVISIBLE);
                tooltip.setStyle('top', selectedItemRect.top + PX);
                tooltip.setStyle('left', selectedItemRect.left + selectedItemRect.width + tooltipSpace + PX);
            }
        },

        /**
         * Sets the selected content type.
         * Overriden to stop redirecting user to the content creation.
         *
         * @protected
         * @method _createContentEvent
         */
         _createContentEvent: function (typeId) {
             var type;

             type = Y.Array.find(this._getContentTypes(), function (t) {
                 return t.get('id') === typeId;
             });

             this.set('selectedContentType', type);

             /**
              * Fired to prepare content model for content type.
              * Listened in the eZS.Plugin.SelectCreateContent
              *
              * @event prepareContentModel
              * @param contentType {eZ.ContentType} the content type model
              */
             this.fire('prepareContentModel', {contentType: type});
         },

         /**
          * Show content type error.
          *
          * @method showContentTypeError
          * @return {cof.ContentTypeSelectorView} the view itself
          */
         showContentTypeError: function () {
            var tooltip = this.get('container').one(SELECTOR_TOOLTIP);

            tooltip.setHTML(this.get('errorMessage'));

            tooltip.addClass(CLASS_TOOLTIP_ERROR);
            tooltip.removeClass(CLASS_HIDDEN);

            return this;
         },
    }, {
        ATTRS: {
            /**
             * The selected content type
             *
             * @attribute selectedContentType
             * @type Object
             */
            selectedContentType: {},

            /**
             * The error message
             *
             * @attribute errorMessage
             * @type String
             */
            errorMessage: {
                value: 'The Content item was correctly created but was deleted because unfortunately it can not be used here, ' +
                    'choose or create another Content item.'
            }
        }
    });
});
