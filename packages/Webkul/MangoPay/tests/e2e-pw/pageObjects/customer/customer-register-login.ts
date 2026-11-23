import { Locator, Page, expect } from "@playwright/test";
import { CommonPage } from "../../utils/tinymce";
import { WebAllLocators } from "../locator";
import * as fs from 'fs';

export class CustomerRegisterLogin {
    readonly page: Page;
    readonly locators: WebAllLocators;

    constructor(page: Page) {
        this.page = page;
        this.locators = new WebAllLocators(page);
    }

    async customerRegisterPageGoto() {
        await this.page.goto("customer/register");
    }

    async customerLoginPageGoto() {
        await this.page.goto("customer/login");
    }

    async customerRegister(
        first_name: string,
        last_name: string,
        email: string,
        password: string
    ) {
        await this.customerRegisterPageGoto();
        await this.locators.customerFirstName.fill(first_name);
        await this.locators.customerLastName.fill(last_name);
        await this.locators.customerEmail.fill(email);
        await this.locators.customerPassword.fill(password);
        await this.locators.customerConfirmPassword.fill(password);
        await this.locators.registerButton.click();
        await expect(this.locators.customerRegisterSuccessToast).toBeVisible();
    }
    
    async customerLogin(email: string, password: string) {
        await this.locators.customerEmail.fill(email);
        await this.locators.customerPassword.fill(password);
        await this.locators.sellerLoginButton.click();
        await this.page
            .getByRole("button", { name: "Sign In" })
            .waitFor({ state: "hidden", timeout: 15000 })
            .catch(() => {});
        await this.page.waitForLoadState("domcontentloaded");
    }

}
