// <reference types="Cypress" />

describe('Plugin Deactivation Survey', () => {

	before(() => {
        cy.visit('/wp-admin/plugins.php');

        // ignore notifications errors if there are any
        cy.intercept({
			method: 'GET',
			url: /newfold-notifications/,
		}, { body: {} });

	});

    it('Plugin deactivate link opens modal', () => {
        // body does not have no scroll class
		cy.get('body').should('not.have.class', 'nfd-noscroll');
        cy.get('.nfd-deactivation-survey__content').should('not.exist');

        // click link
        cy.get('.deactivate a[id*="' + Cypress.env('pluginId') + '"]').click();

        // body has no scroll class
		cy.get('body').should('have.class', 'nfd-noscroll');
        
        // modal exists
        cy.get('.nfd-deactivation-survey__content')
            .scrollIntoView()
            .should('be.visible');
    });

    it('Cancel button exists and exits modal', () => {
        cy.get('button[nfd-deactivation-survey-destroy]')
            .should('be.visible');
        cy.get('button[nfd-deactivation-survey-destroy]').click();

        cy.get('body').should('not.have.class', 'nfd-noscroll');
        cy.get('.nfd-deactivation-survey__content').should('not.exist');
    });

    it('Skip button deactivates plugin', () => {
        // ignore notifications errors if there are any
        cy.intercept({
			method: 'GET',
			url: /newfold-notifications/,
		}, { body: {} });

        // reopen modal
        cy.get('.deactivate a[id*="' + Cypress.env('pluginId') + '"]').click();
        // skip & deactivate functions

        cy.get('button[nfd-deactivation-survey-skip]')
            .should('be.visible');
        cy.get('button[nfd-deactivation-survey-skip]').click();
        cy.wait(500);
        // verify modal closed
        cy.get('.nfd-deactivation-survey__content').should('not.exist');
        // verify plugin is deactivated
        cy.get('.deactivate a[id*="' + Cypress.env('pluginId') + '"]').should('not.exist');
        cy.get('.activate a[id*="' + Cypress.env('pluginId') + '"]').should('exist');
        // reactivate plugin
        cy.get('.activate a[id*="' + Cypress.env('pluginId') + '"]').click();
        cy.wait(500);
    });


    it('Survey successfully deactivates plugin', () => {
        // ignore notifications errors if there are any
        cy.intercept({
			method: 'GET',
			url: /newfold-notifications/,
		}, { body: {} });
        cy.intercept({
			method: 'POST',
			url: /newfold-data(\/|%2F)v1(\/|%2F)events/,
		}).as('surveyEvent');

        // reopen modal
        cy.get('.deactivate a[id*="' + Cypress.env('pluginId') + '"]').click();
        // can enter reason
        const ugcReason = 'automated testing';
        cy.get('#nfd-deactivation-survey__input').type(ugcReason);
        // submit and deactivate works
        cy.get('input[nfd-deactivation-survey-submit]')
            .should('be.visible');
        cy.get('input[nfd-deactivation-survey-submit]').click();
        cy.wait('@surveyEvent')
            // .its('request.body.action').should('eq', 'deactivation_survey_freeform')
            .its('request.body.data.survey_input').should('eq', ugcReason);
        cy.wait(500);
        // verify plugin is deactivated
        cy.get('.deactivate a[id*="' + Cypress.env('pluginId') + '"]').should('not.exist');
        cy.get('.activate a[id*="' + Cypress.env('pluginId') + '"]').should('exist');
        // reactivate plugin
        cy.get('.activate a[id*="' + Cypress.env('pluginId') + '"]').click();
        cy.wait(500);
    });

});
