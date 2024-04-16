$.widget('tconway.userList', {
   options: {
       selectors: {
            btnDelete: '.btn-delete',
            modalDiv: '#delete-modal',
            deleteForm: '#delete-form'
       }
   },

   _create: function() {
       let that = this;
       that.addListeners();
   },

   addListeners: function() {
       let that = this,
           s = that.options.selectors,
           modalBody = 'Are you sure you want to delete this user?';

       that.el().on('click', s.btnDelete, function (e) {
           e.preventDefault();
           $(s.deleteForm).attr('action', $(e.currentTarget).data('url'));
           if ($(s.modalDiv).hasClass('modal')) {
               $(s.modalDiv).makeModal('setBody', modalBody);
               $(s.modalDiv).makeModal('open');
           } else {
               $(s.modalDiv).makeModal({
                   modalBody: modalBody,
                   modalTitle: 'Delete User',
                   buttons: [
                       {
                           text: 'Cancel',
                           cssClass: 'btn-default',
                           onClickCallback: function (e) {
                               $(s.modalDiv).makeModal('close');
                           }
                       },
                       {
                           text: 'Delete User',
                           cssClass: 'btn-danger',
                           onClickCallback: function (e) {
                               $(s.deleteForm).submit();
                           }
                       }
                   ]
               });
           }
       });
   },

   el: function() {
       return this.element;
   }

});

$(document).ready(function() {
    $('body').userList({});
});
