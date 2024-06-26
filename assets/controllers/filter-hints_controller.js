import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
  connect() {
    this.hints = document.querySelectorAll('[data-filter-hint]');

    this.hints.forEach(hint => {
      hint.addEventListener('click', this.handleFilterValue.bind(this, hint));
    });
  }

  handleFilterValue(hint) {
    const hintValue = hint.dataset.filterHint;
    let filter;

    if ("reset" === hintValue) {
      const filters = document.querySelectorAll('[data-filter]');

      filters.forEach(filter => {
        filter.checked = false;
      });

      filter = filters[0]; // Select the first filter to trigger the event
    } else {
      filter = document.querySelector(`[data-filter="${hintValue}"]`);
      filter.checked = false;
    }

    if (filter.length === 0) {
      return;
    }

    filter.dispatchEvent(new Event('change', {bubbles: true}));
  }
}
