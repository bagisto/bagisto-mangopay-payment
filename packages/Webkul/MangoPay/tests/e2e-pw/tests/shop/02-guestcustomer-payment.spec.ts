import { expect, test } from "../../setup";
import { adminCreateProduct } from "../../pageObjects/admin/admin-product-create";
import {
    generateDescription,
    generateName,
    generateSKU,
} from "../../utils/faker";
import { readData, saveData } from "../../utils/dataManager";

test.describe("guest customer uses mangopay payment", () => {
    const productData = {
        name: `simple-${generateName()}`,
        sku: generateSKU(),
        productNumber: generateSKU(),
        shortDescription: generateDescription(),
        description: generateDescription(),
        price: "199",
        weight: 25,
        inventory: 1000,
    };
    test("admin create simple product", async ({ adminPage }) => {
        const createProduct = new adminCreateProduct(adminPage);

        await createProduct.adminProductPageGoto();

        await createProduct.adminCreateproduct(
            productData.sku,
            productData.name,
            productData.description,
            productData.price,
            productData.weight,
            productData.inventory,
        );

        saveData("product-details", productData);
    });

    test("customer chckout the product", async ({ page }) => {
        test.skip(
            !process.env.MANGOPAY_CLIENT_ID || !process.env.MANGOPAY_PASSPHRASE,
            "MangoPay sandbox credentials (MANGOPAY_CLIENT_ID, MANGOPAY_PASSPHRASE) are not set.",
        );

        await page.goto("");
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

        await page.getByRole("textbox", { name: "Company Name" }).fill("test");
        await page.getByRole("textbox", { name: "First Name" }).fill("test");
        await page.getByRole("textbox", { name: "Last Name" }).fill("webkul");
        await page
            .getByRole("textbox", { name: "email@example.com" })
            .fill("test@webkul.in");
        await page
            .getByRole("textbox", { name: "Street Address" })
            .fill("arv park");
        await page
            .locator('select[name="billing\\.country"]')
            .selectOption("IN");
        await page.locator('select[name="billing\\.state"]').selectOption("UP");
        await page
            .getByRole("textbox", { name: "Zip/Postcode" })
            .fill("201301");
        await page.getByRole("textbox", { name: "City" }).fill("noida");
        await page
            .getByRole("textbox", { name: "Telephone" })
            .fill("1234456780");
        // await page.locator("#save_address").nth(1).click();

        /*Save address */
        // await page.getByRole("button", { name: "Save" }).click();

        await page.getByRole("button", { name: "Proceed" }).click();

        // Shipping Method
        await page.getByText("Free Shipping").first().click();

        // Payment Method
        await page.getByAltText("Mangopay").click();

        // Place Order
        await page.getByRole("button", { name: "Place Order" }).click();
    });
});
