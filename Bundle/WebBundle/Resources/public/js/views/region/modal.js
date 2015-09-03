/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class ModalRegion extends Backbone.Marionette.Region {
  constructor(options) {
    this.el = '.modal-region';

    super(options);

    this.listenTo(App.vent, 'modal:close', this.closeModal());
  }

  onShow(view) {
    $('.modal-overlay').addClass('visible');
    this.listenTo(view, "modal:close", this.closeModal);
    this.$el.addClass('visible');

    Mousetrap.bind('esc', () => {
      this.closeModal();
    });
    $(".modal-overlay").click(() => {
      this.closeModal();
    });
  }

  closeModal() {
    this.$el.removeClass('visible');
    $('.modal-overlay').removeClass('visible');
    this.stopListening();
    Mousetrap.unbind('esc');
    this.empty();
  }
}