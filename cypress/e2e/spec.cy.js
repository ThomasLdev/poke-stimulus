describe('list filters', () => {
  it('passes', () => {
    cy.visit('https://localhost');
    cy.get('[data-nav-products]').click();
    const productsContainer = cy.get('[data-products-container]');

    productsContainer.should('exist').children().should('have.length', 15);

    const dropdownFlavor = cy.get('[data-dropdown-toggle="dropdown-flavor"]');

    dropdownFlavor.click();

    const flavorLinksContainer = cy.get('#dropdown-flavor ul');

    flavorLinksContainer.children().should('have.length', 8);

    flavorLinksContainer.children().first().click();

    cy.get('[data-products-container]').children().should('have.length', 3);

    dropdownFlavor.click();

    cy.get('[data-filter-hint="flavor-raspberry"]').should('exist').click();

    cy.get('[data-products-container]').children().should('have.length', 15);
  })
})
