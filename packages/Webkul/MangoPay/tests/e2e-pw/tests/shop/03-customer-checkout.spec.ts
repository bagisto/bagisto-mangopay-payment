import { expect, test } from "../../setup";
import { adminCreateProduct } from "../../pageObjects/admin/admin-product-create";
import {
    generateDescription,
    generateName,
    generateSKU,
} from "../../utils/faker";
import { readData, saveData } from "../../utils/dataManager";
import { read } from "node:fs";
import { CustomerRegisterLogin } from "../../pageObjects/customer/customer-register-login";
import { addAddress } from "../../utils/customer";

test.describe("customer uses mangopay payment", () => {
    
   test("customer login and add address", async ({ page }) => {
        const data = readData("customer");

        const customer = new CustomerRegisterLogin(page);

        await customer.customerLoginPageGoto();

        await customer.customerLogin(
            data.email,
            data.password
        );
       await addAddress(page); // ✅ pass page
});

    test("customer chckout the product", async ({ page }) => {
        test.skip(
            !process.env.MANGOPAY_CLIENT_ID || !process.env.MANGOPAY_PASSPHRASE,
            "MangoPay sandbox credentials (MANGOPAY_CLIENT_ID, MANGOPAY_PASSPHRASE) are not set.",
        );

        const data = readData("customer");

        const customer = new CustomerRegisterLogin(page);

        await customer.customerLoginPageGoto();

        await customer.customerLogin(
            data.email,
            data.password
        );

        const product = readData("product-details");

        await page.waitForLoadState("networkidle");

        await page
            .getByRole("textbox", { name: "Search products here" })
            .fill(product.name);

        await page
            .getByRole("textbox", { name: "Search products here" })
            .press("Enter");

        // Add to Cart
        await page
            .locator("(//button[contains(@class,'secondary-button')])[2]")
            .click();

        await expect(
            page.getByText("Item Added Successfully").first(),
        ).toBeVisible();

        // Proceed to Checkout
        const shoppingCartIcon = page.locator(
            "(//span[contains(@class,'icon-cart')])[1]",
        );

        if (await shoppingCartIcon.isVisible()) {
            await shoppingCartIcon.click();
        }

        await page
            .locator('//a[contains(.," Continue to Checkout ")][1]')
            .click();
        
        await page.locator('.icon-radio-unselect').first().click();

        await page.getByRole("button", { name: "Proceed" }).click();

        // Shipping Method
        await page.getByText("Free Shipping").first().click();

        // Payment Method
        await page.getByAltText("Mangopay").click();

        // // Place Order
        await page.getByRole("button", { name: "Place Order" }).click();
    });
});
