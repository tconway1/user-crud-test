$.widget('tconway.makeModal', {

    options: {
        autoOpen: true,
        buttons: null,
        destroyOnClose: false,
        modalBody: null,
        selectors: {
            modalFooter: '.modal-footer',
            modalTitle: '.modal-title',
            modalBody: '.modal-body'
        }
    },

    _create: function () {
        let that = this,
            opts = this.options,
            el = that.el();
        el.addClass('modal fade');
        if (opts.modalTitle) {
            that.setTitle(opts.modalTitle);
        }
        el.html(that._getTemplate());
        el.prop('role', 'dialog');
        el.prop('aria-hidden', 'true');
        that.addButtons(opts.buttons);

        el.on('hidden.bs.modal', function () {
            if (opts.destroyOnClose === true) {
                el.remove();
            }
        });

        if (opts.autoOpen) {
            that.open();
        }
    },

    // Get default template for popup
    _getTemplate: function () {
        let that = this,
            opts = that.options,
            titleTag = opts.titleTag || 'h5',
            modalBody = opts.modalBody || '',
            tpl = '<div class="modal-dialog" role="document">\
            <div class="modal-content">\
            <div class="modal-header">\
			<' + titleTag + ' class="modal-title">' + opts.modalTitle + '</' + titleTag + '>\
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
			</div>';

        tpl += '<div class="modal-body"><p>'+modalBody+'</p></div>';

        tpl += '<div class="modal-footer">\
			</div></div></div>';

        return tpl;
    },

    // Add custom buttons
    addButtons: function (buttons) {
        let that = this;
        if ($.isArray(buttons)) {
            $(buttons).each(function (i, btn) {
                that.addButton(btn);
            });
        }
    },

    // Add 1 button to toolbar
    addButton: function (btnInfo) {
        let that = this,
            s = that.options.selectors,
            footer = that.element.find(s.modalFooter),
            btn;

        btn = that._makeBtn(btnInfo, btnInfo.tag ?? 'button');

        footer.prepend(btn);
    },

    // Set title
    setTitle: function (title) {
        this.element.find(this.options.selectors.modalTitle).html(title);
    },

    // set body
    setBody: function (modalBody) {
        this.element.find(this.options.selectors.modalBody).html('<p>'+modalBody+'</p>');
    },

    _makeBtn: function (btnInfo, tag = 'button', defaultCss = 'btn m-l-10') {
        let that = this,
            btn = $('<'+tag+'/>');

        btn.addClass(defaultCss);
        btn.prop('type', btnInfo.type ? btnInfo.type : 'button');
        btn.html(btnInfo.text);

        if (btnInfo.cssClass) {
            btn.addClass(btnInfo.cssClass);
        }
        if ($.isPlainObject(btnInfo.attrs)) {
            for (k in btnInfo.attrs) {
                btn.attr(k, btnInfo.attrs[k]);
            }
        }
        if (btnInfo.onClickCallback) {
            btn.on('click', function (ev) {
                ev.preventDefault();
                btnInfo.onClickCallback.call(this, ev, that);
            });
        }

        return btn;
    },

    // Open modal
    open: function (openOpts) {
        let o = openOpts || {
            show: true,
            backdrop: 'static',
            keyboard: false
        };
        this.element.modal(o);
    },

    // close modal
    close: function() {
        this.element.modal('hide');
    },

    el: function () {
        return this.element;
    }
});
