import { expect, test } from "../../setup";
import { readData } from "../../utils/dataManager";

test.describe("mangopay return page", () => {
    test("places no order for a return the checkout never started", async ({ page }) => {
        const product = readData("product-details");

        test.skip(!product, "Run 02-guestcustomer-payment first: it creates the product.");

        await page.goto("");

        await page
            .getByRole("textbox", { name: "Search products here" })
            .fill(product.name);

        await page
            .getByRole("textbox", { name: "Search products here" })
            .press("Enter");

        await page
            .locator("(//button[contains(@class,'secondary-button')])[2]")
            .click();

        await expect(page.getByText("Item Added Successfully").first()).toBeVisible();

        await page.goto("mangopay/standard/success?transactionId=forged-payin");

        await expect(page).toHaveURL(/checkout\/cart/);

        await expect(
            page.getByText("Your MangoPay payment could not be confirmed, so no order was placed.").first(),
        ).toBeVisible();

        await expect(page.getByText(product.name).first()).toBeVisible();
    });
});
