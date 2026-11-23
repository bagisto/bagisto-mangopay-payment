import { Locator, Page, expect } from "@playwright/test";
import { WebAllLocators } from "../locator";
import { sellerProductSearchonFront } from "../../pageObjects/seller/seller-product-search";
import { SellerFlagSettings } from "../../pageObjects/seller/seller-flag";
import { sellerShowPubliclySettings } from "../../pageObjects/seller/seller-profile-show-publicly";

export class marketplaceSellerSettings {
    readonly page: Page;
    readonly locators: WebAllLocators;
    readonly sellerflagSettings: SellerFlagSettings;
    readonly sellerShowPubliclySetting : sellerShowPubliclySettings;

    constructor(page: Page) {
        this.page = page;
        this.locators = new WebAllLocators(page);
        this.sellerflagSettings = new SellerFlagSettings(page);
        this.sellerShowPubliclySetting = new sellerShowPubliclySettings(page);
    }

    async adminMarketplaceConfigurationgoto() {
        await this.page.goto(`${process.env.APP_ADMIN_URL || "admin"}/configuration/marketplace/sellers`);
    }

    async adminMarketplaceSellerSectiongoto() {
        await this.page.goto(`${process.env.APP_ADMIN_URL || "admin"}/marketplace/sellers`);
    }

    async SellerProfileSectiongoto() {
        await this.page.goto("seller/profile");
    }

    async SellerOrdersSectiongoto() {
        await this.page.goto("seller/orders");
    }

    async sellerApprovalRequiredStatus() {
        await this.adminMarketplaceConfigurationgoto();
        const seller_approval = await this.page
            .locator(
                '//input[@id="marketplace[sellers][registration][approval_required]"]'
            )
            .isChecked();

        await this.adminMarketplaceSellerSectiongoto();

        if (seller_approval) {
            await expect(
                this.page.locator("label.label-info.py-1").first()
            ).toBeVisible();
        } else {
            await expect(
                this.page.locator("label.label-active.py-1").first()
            ).toBeVisible();
        }
    }

    async sellerMinimumOrderAmountStatus() {
        await this.adminMarketplaceConfigurationgoto();
        const minimum_order_amount_status = await this.page
            .locator(
                '//input[@id="marketplace[sellers][capabilities][enable_minimum_order_amount]"]'
            )
            .isChecked();

        await this.SellerProfileSectiongoto();

        if (minimum_order_amount_status) {
            await expect(this.locators.sellerMinimumOrderAmount).toBeVisible();
        } else {
            await expect(
                this.locators.sellerMinimumOrderAmount
            ).not.toBeVisible();
        }
    }

    async sellerCanCreateInvoice() {
        await this.adminMarketplaceConfigurationgoto();
        const seller_can_create_invoice = await this.page
            .locator(
                '//input[@id="marketplace[sellers][capabilities][can_create_invoice]"]'
            )
            .isChecked();

        await this.SellerOrdersSectiongoto();
        /**
         * Click on the "Which View" button for the order with a status of "Pending." According to the index: [3]
         */
        await this.page.waitForSelector("p.label-pending");
        const pending = await this.page.$$("p.label-pending"); // Select all elements containing 'Pending'
        const targetElement = pending[0]; // First match
        const lastChildHandle = await targetElement.evaluateHandle((el) => {
            let parent: HTMLElement | null = el as HTMLElement;
            for (let i = 0; i < 3; i++) {
                if (!parent) return null; // Safety check
                parent = parent.parentElement;
            }
            return parent?.lastElementChild ?? null; // Get the last child of the 3rd parent
        });
        await lastChildHandle.asElement()?.click(); // Click safely

        if (seller_can_create_invoice) {
            await expect(
                this.page.locator('//a[contains(.,"Invoice")]')
            ).toBeVisible();

            await this.page.click('//a[contains(.,"Invoice")]');

            /**
             * Create the Invoice from the Seller end
             */
            await this.page.waitForSelector(
                '//p[contains(.,"Create Invoice")]'
            );
            await this.page.click('//button[contains(.,"Create Invoice")]');

            await expect(this.page.locator("div.fixed.top-5")).toHaveText(
                "Invoice created successfully"
            );
        } else {
            /**
             * Expect that the button is not visible if the status is Disable.
             */
            await expect(
                this.page.locator('//a[contains(.,"Invoice")]')
            ).not.toBeVisible();
        }
    }

    async sellerCanCreateShipment() {
        await this.adminMarketplaceConfigurationgoto();
        const seller_can_create_shipment = await this.page
            .locator(
                '//input[@id="marketplace[sellers][capabilities][can_create_invoice]"]'
            )
            .isChecked();

        await this.SellerOrdersSectiongoto();

        /**
         * Click on the "Which View" button for the order with a status of "Pending." According to the index: [3]
         */
        await this.page.waitForSelector("p.label-processing");
        const processing = await this.page.$$("p.label-processing"); // Select all elements containing 'Pending'
        const targetElement = processing[0]; // First match
        const lastChildHandle = await targetElement.evaluateHandle((el) => {
            let parent: HTMLElement | null = el as HTMLElement;
            for (let i = 0; i < 3; i++) {
                if (!parent) return null; // Safety check
                parent = parent.parentElement;
            }
            return parent?.lastElementChild ?? null; // Get the last child of the 3rd parent
        });
        await lastChildHandle.asElement()?.click(); // Click safely

        if (seller_can_create_shipment) {
            await expect(
                this.page.locator('//a[contains(.,"Ship")]')
            ).toBeVisible();

            await this.page.click('//a[contains(.,"Ship")]');
            await this.page.waitForSelector(
                '//button[contains(.," Create Shipment ")]'
            );

            await this.page.fill(
                'input[name="shipment[carrier_title]"]',
                "FedEx"
            );
            await this.page.fill(
                'input[name="shipment[track_number]"]',
                "124354FEDEX"
            );

            await this.page.selectOption('select[name="shipment[source]"]', {
                index: 0,
            });
            /**
             * Create the Invoice from the Seller end
             */
            await this.page.click('//button[contains(.," Create Shipment ")]');

            await expect(this.page.locator("div.fixed.top-5")).toHaveText(
                "Shipment created successfully"
            );

        } else {
            /**
             * Expect that the button is not visible if the status is Disable.
             */
            await expect(
                this.page.locator('//a[contains(.,"Ship")]')
            ).not.toBeVisible();
        }
    }

    async sellerCanCancelOrder() {
        await this.adminMarketplaceConfigurationgoto();

        const seller_can_cancel_order = await this.page
            .locator(
                '//input[@id="marketplace[sellers][capabilities][can_create_invoice]"]'
            )
            .isChecked();

        await this.SellerOrdersSectiongoto();
        /**
         * Click on the "Which View" button for the order with a status of "Pending." According to the index: [3]
         */
        await this.page.waitForSelector("p.label-pending");
        const pending = await this.page.$$("p.label-pending"); // Select all elements containing 'Pending'
        const targetElement = pending[0]; // First match
        const lastChildHandle = await targetElement.evaluateHandle((el) => {
            let parent: HTMLElement | null = el as HTMLElement;
            for (let i = 0; i < 3; i++) {
                if (!parent) return null; // Safety check
                parent = parent.parentElement;
            }
            return parent?.lastElementChild ?? null; // Get the last child of the 3rd parent
        });
        await lastChildHandle.asElement()?.click(); // Click safely

        if (seller_can_cancel_order) {
            await expect(
                this.page.locator('//a[contains(.," Cancel ")]')
            ).toBeVisible();

            await this.page.click('//a[contains(.," Cancel ")]');

            /**
             * Create the Invoice from the Seller end
             */
            await this.page.waitForSelector('//button[contains(.,"Agree")]');
            await this.page.click('//button[contains(.,"Agree")]');

            await expect(this.page.locator("div.fixed.top-5")).toHaveText(
                "Order has been canceled"
            );
        } else {
            /**
             * Expect that the button is not visible if the status is Disable.
             */
            await expect(
                this.page.locator('//a[contains(.," Cancel ")]')
            ).not.toBeVisible();
        }
    }

    async sellerFlagEnable() {
        await this.page.goto(`${process.env.APP_ADMIN_URL || "admin"}/configuration/marketplace/moderation`);

        const seller_flag = await this.page
            .locator(
                '//input[@id="marketplace[moderation][seller_flags][flag_enabled]"]'
            )
            .isChecked(); // await adminPage.click('a.primary-button');

        await this.sellerflagSettings.CheckSellerFlag();

        if (seller_flag) {
            /**
             * To check the Seller Report flag button is visible or not
             */

            await expect(
                this.page.locator("span.mp-issue-icon.text-2xl")
            ).toBeVisible();
        } else {
            await expect(
                this.page.locator("span.mp-issue-icon.text-2xl")
            ).not.toBeVisible();
        }
    }

    async sellerProfileShowPublicly() {
        await this.adminMarketplaceConfigurationgoto();

        const show_publicly = await this.page
            .locator(
                '//input[@id="marketplace[sellers][registration][show_publicly]"]'
            )
            .isChecked(); // await adminPage.click('a.primary-button');

        await this.sellerShowPubliclySetting.CheckShowProfilePublicly();
    }
}
