import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
  static values = {
    route: String,
  }

  productContainer;
  filterHintsContainer;

  connect() {
    this.productContainer = document.querySelector('[data-products-container]');
    this.filterHintsContainer = document.querySelector('[data-filter-hints-container]');
    this.element.addEventListener('change', this.handleChange.bind(this));
  }

  handleChange(event) {
    fetch(this.routeValue, {
      method: 'POST',
      body: this.getFormData(),
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Content-Type': 'application/json',
      },
    })
      .then(response => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json(); // Parse the response as text
      })
      .then(data => {
        this.render(data);
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }

  render(data) {
    this.productContainer.innerHTML = data.products;
    this.filterHintsContainer.innerHTML = data.filterHints;
  }

  getFormData() {
    let formData = {};

    for (let pair of new FormData(this.element).entries()) {
      if (formData[pair[0]]) {
        // If the key already exists, append the new value
        formData[pair[0]] = [...formData[pair[0]], pair[1]];
      } else {
        // Otherwise, add the key/value pair to the formData object
        formData[pair[0]] = [pair[1]];
      }
    }

    return JSON.stringify(formData);
  }
}
