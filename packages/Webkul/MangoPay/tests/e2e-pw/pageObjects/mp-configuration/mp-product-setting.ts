import { Locator, Page, expect } from "@playwright/test";
import * as fs from "fs";
import { WebAllLocators } from "../locator";
import { sellerProductSearchonFront } from "../../pageObjects/seller/seller-product-search";

export class marketplaceProductSettings {
    readonly page: Page;
    readonly locators: WebAllLocators;
    readonly sellerProductSearch: sellerProductSearchonFront;

    constructor(page: Page) {
        this.page = page;
        this.locators = new WebAllLocators(page);
        this.sellerProductSearch = new sellerProductSearchonFront(page);
    }

    async sellerProductSectionGoto() {
        await this.page.goto("seller/catalog/products");
    }

    async adminProductApprovalgoto() {
        await this.page.goto(`${process.env.APP_ADMIN_URL || "admin"}/marketplace/catalog/products`);
    }

    async adminMarketplaceConfigurationgoto() {
        await this.page.goto(`${process.env.APP_ADMIN_URL || "admin"}/configuration/marketplace/products`);
    }

    async productApprovalStatus() {
        await this.adminMarketplaceConfigurationgoto();
        const status = await this.locators.productApproval.isChecked();
        await this.adminProductApprovalgoto();

        if (status) {
            await expect(
                this.page.locator('//p[contains(text(),"Disapproved")]').nth(0)
            ).toBeVisible();
        } else {
            await expect(
                this.page.locator('//p[contains(text(),"Approved")]').nth(0)
            ).toBeVisible();
        }
    }

    async sellerCanAssignProduct() {
        await this.adminMarketplaceConfigurationgoto();
        const sellerCanAssign =
            await this.locators.sellerCanAssignInput.isEnabled();

        await this.sellerProductSectionGoto();
        await this.page.click("a.primary-button");

        const searchProducts = this.page.locator(
            '(//p[contains(.," Search Products ")])[1]'
        );

        if (sellerCanAssign) {
            await expect(searchProducts).toBeVisible();
        } else {
            await expect(searchProducts).not.toBeVisible();
        }
    }

    async sellerCanAssignAdminProduct() {
        await this.adminMarketplaceConfigurationgoto();
        const sellerCanAssign =
            await this.locators.sellerCanAssignInput.isEnabled();

        await this.sellerProductSectionGoto();
        await this.page.click("a.primary-button");

        const searchProducts = this.page.locator(
            '(//p[contains(.," Search Products ")])[1]'
        );

        if (sellerCanAssign) {
            await expect(searchProducts).toBeVisible();
        } else {
            await expect(searchProducts).not.toBeVisible();
            await this.locators.sellerCanAssignInput.click();
        }
    }

    async sellerCanCreateProduct() {
        await this.adminMarketplaceConfigurationgoto();
        const sellerCanCreate =
            await this.locators.sellerCanCreateInput.isChecked();

        await this.sellerProductSectionGoto();
        await this.locators.createProductButton.click();

        const createProducts = this.page.locator(
            '//p[contains(.," Create New Products ")]'
        );
        if (sellerCanCreate) {
            await expect(createProducts).toBeVisible();
        } else {
            await expect(createProducts).not.toBeVisible();
        }
    }

    async showProductProgressBar() {
        const randomID = Date.now();
        const productDetails = {
            sku: "SKU" + randomID,
            product_name: "Product Name" + randomID,
            short_description: "Fashion Product",
            description: "Fashion Product",
            meta_title: "Meta Title",
            meta_keywords: "Meta Keyword",
            meta_description: "Meta Description",
            price: "100",
            weight: "0.322",
            inventories: "50",
        };
        await this.adminMarketplaceConfigurationgoto();

        const sellerCanCreate =
            await this.locators.sellerCanCreateInput.isChecked();
        const showProgressBar =
            await this.locators.showProgressBarInput.isChecked();

        await this.sellerProductSectionGoto();

        await this.page.click("a.primary-button");
        await this.page.waitForURL("seller/catalog/products/create");

        await this.locators.selectProductType.selectOption("simple");
        await this.locators.selectAttribute
            .selectOption("1");
        await this.locators.productSku.fill(productDetails.sku);

        await this.locators.clickContinueButton.click();
        await this.page.waitForSelector(
            'button.primary-button:has-text("Save Product")'
        );
        await this.page.waitForSelector('form[enctype="multipart/form-data"]', {
            state: "visible",
        });

        await this.page.locator("#name").fill(productDetails.product_name);

        if (sellerCanCreate) {
            const progressBar = this.page.locator("div.relative.h-4");
            if (showProgressBar) {
                await expect(progressBar).toBeVisible();
            } else {
                await expect(progressBar).not.toBeVisible();
            }
        }
    }

    async productFlagStatus() {
        const sellerProductdetails = JSON.parse(
            fs.readFileSync("seller-simple-product-details.json", "utf-8")
        );

        await this.page.goto(`${process.env.APP_ADMIN_URL || "admin"}/configuration/marketplace/moderation`);
        const productFlag = await this.locators.productFlagInput.isChecked();

        await this.sellerProductSearch.SellerProductSearchOnFront();

        if (productFlag) {
            const sellerProduct = this.page.locator("a.text-lg");
            if (await sellerProduct.isVisible()) {
                await expect(
                    this.page.locator(
                        '//span[@class="flex cursor-pointer items-center gap-2.5"]'
                    )
                ).toBeVisible();
            } else {
                await expect(
                    this.page.locator(
                        '//span[@class="flex cursor-pointer items-center gap-2.5"]'
                    )
                ).not.toBeVisible();
            }
        }
    }
}
