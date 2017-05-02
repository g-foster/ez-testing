/*
 * Copyright (C) eZ Systems AS. All rights reserved.
 * For full copyright and license information view LICENSE file distributed with this source code.
 */
YUI.add('ez-sectionserversideview', function (Y) {
    "use strict";
    /**
     * Provides the section server side view
     *
     * @module ez-sectionserversideview
     */
    Y.namespace('eZ');

    var events = {
            '.ez-section-assign-button': {
                'tap': '_pickSubtree'
            },
        };

    /**
     * The section server side view. It adds the handling of the section assign
     * button.
     *
     * @namespace eZ
     * @class SectionServerSideView
     * @constructor
     * @extends eZ.ServerSideView
     */
    Y.eZ.SectionServerSideView = Y.Base.create('sectionServerSideView', Y.eZ.ServerSideView, [], {
        initializer: function () {
            this._addDOMEventHandlers(events);
        },

        /**
         * tap event handler on the section assign buttons. It launches the
         * universal discovery widget so that the user can pick some contents.
         *
         * @method _pickSubtree
         * @protected
         * @param {EventFacade} e
         */
        _pickSubtree: function (e) {
            var button = e.target,
                refreshView = Y.bind(this._refreshView, this),
                unsetLoading = Y.bind(this._uiUnsetAssignSectionLoading, this, button);

            e.preventDefault();
            this._uiSetAssignSectionLoading(button);
            this.fire('contentDiscover', {
                config: {
                    title: button.getAttribute('data-universaldiscovery-title'),
                    cancelDiscoverHandler: unsetLoading,
                    multiple: true,
                    data: {
                        sectionId: button.getAttribute('data-section-rest-id'),
                        sectionName: button.getAttribute('data-section-name'),
                        afterUpdateCallback: refreshView,
                    },
                },
            });
        },

        /**
         * Changes the state of the provided assign button to be *loading* and
         * to be disabled
         *
         * @method _uiSetAssignSectionLoading
         * @protected
         * @param {Y.Node} button
         */
        _uiSetAssignSectionLoading: function (button) {
            button.addClass('is-loading').set('disabled', true);
        },

        /**
         * Changes the state of the provided assign button to not be *loading*
         * and to be enabled.
         *
         * @method _uiUnsetAssignSectionLoading
         * @protected
         * @param {Y.Node} button
         */
        _uiUnsetAssignSectionLoading: function (button) {
            button.removeClass('is-loading').set('disabled', false);
        },

        /**
         * Refreshes the view
         *
         * @method _refreshView
         * @protected
         */
        _refreshView: function () {
            /**
             * Fired when the view needs to be refreshed
             * @event refreshView
             */
            this.fire('refreshView');
        },
    });
});
