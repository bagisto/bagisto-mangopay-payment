import { Locator, Page, expect } from "@playwright/test";
import { WebAllLocators } from "../locator";

export class marketplaceConfiguration {
    readonly page: Page;
    readonly locators: WebAllLocators;

    constructor(page: Page) {
        this.page = page;
        this.locators = new WebAllLocators(page);
    }

    async adminMarketplaceConfigurationgoto() {
        await this.page.goto(`${process.env.APP_ADMIN_URL || "admin"}/configuration/marketplace/general`);
    }

    async enableMarketplace() {
        await this.adminMarketplaceConfigurationgoto();
        const status = await this.page.locator('label > div').first();
        if (!(await status.isChecked())) {
            await status.click();
        }
    }

    async fillMarketplaceConfigurationDetails(
        admin_commission: string,
        red_flag: string,
        limit_count: string,
        banner_title: string,
        banner_description: string,
        banner_button_title: string
    ) {
        await this.page.fill(
            '//input[@id="marketplace[general][general][admin_commission_percentage]"]',
            admin_commission
        );
        await this.page.fill(
            '//input[@id="marketplace[moderation][seller_flags][red_flag_limit]"]',
            red_flag
        );
        await this.page.fill(
            '//input[@id="marketplace[featured_sellers][settings][limit_count]"]',
            limit_count
        );

        await this.page.fill(
            '//input[@id="marketplace[landing_page][banner][banner_title]"]',
            banner_title
        );
        await this.page.fill(
            '//textarea[@id="marketplace[landing_page][banner][banner_description]"]',
            banner_description
        );
        await this.page.fill(
            '//input[@id="marketplace[landing_page][banner][banner_btn_title]"]',
            banner_button_title
        );

        await this.page.click(
            '//button[contains(.," Save Configuration ")]'
        );

        await expect(this.page.getByText('Configuration saved successfully').first()).toBeVisible();
        await this.page.waitForTimeout(2000);

        await expect(this.page.locator('(//p[contains(.," Marketplace")])[1]')).toBeVisible();
    }

    async globalCommissionSettings(){
        await this.adminMarketplaceConfigurationgoto()
        const globalCommission = await this.page.locator(
            '//input[@id="marketplace[general][general][admin_commission_percentage]"]').inputValue();

        return globalCommission;
    }


}
