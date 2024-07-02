import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
  static targets = [ "message" ]

  connect() {
    this.messageTargets.forEach((message) => {
      setTimeout(() => {
        message.remove();
      }, 4700);
    });
  }
}
