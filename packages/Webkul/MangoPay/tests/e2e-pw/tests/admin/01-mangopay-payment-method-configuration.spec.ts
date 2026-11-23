import { marketplaceConfiguration } from "../../pageObjects/mp-configuration/configuration";
import { MangoPayConfigurationPage } from "../../pageObjects/mangopay-configuration/payment-method-configuration";
import { expect, test } from "../../setup";

test.describe("payment method configuration for mangopay", () => {
    /**
     * Sandbox credentials come from the environment (masked CI variables) and are never committed;
     * without them placeholders are saved, which is enough for every spec that does not pay.
     */
    const mangoPayConfig = {
        title: "Mangopay",
        description: "This is a test payment method for Mangopay",
        passphrase: process.env.MANGOPAY_PASSPHRASE || "e2e-placeholder-passphrase",
        clientId: process.env.MANGOPAY_CLIENT_ID || "e2e-placeholder-client",
    };

    test("enable marketplace before configuring mangopay payment method", async ({
        adminPage,
    }) => {
        const paymentMethod = new MangoPayConfigurationPage(adminPage);
        const marketplaceConfig = new marketplaceConfiguration(adminPage);
        await marketplaceConfig.enableMarketplace();
        await marketplaceConfig.locators.saveButton.click();

        await expect(
            paymentMethod.configurationSuccessmessagepage,
        ).toBeVisible();
    });

   test("admin configures the Mangopay payment method", async ({
        adminPage,
        }) => {
        const paymentMethod = new MangoPayConfigurationPage(adminPage);

        await paymentMethod.navigateToMangoPayPaymentMethodConfiguration();

        await paymentMethod.configureMangoPayPaymentMethod(
            mangoPayConfig.title,
            mangoPayConfig.description,
            mangoPayConfig.clientId,
            mangoPayConfig.passphrase,
        );

        await expect(
            paymentMethod.configurationSuccessmessagepage,
        ).toBeVisible();


        });


});
