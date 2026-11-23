import { test, expect } from "../../setup";
import { generateEmail } from "../../utils/faker";
import { CustomerRegisterLogin } from "../../pageObjects/customer/customer-register-login";
import * as fs from "fs";
import { readData, saveData } from "../../utils/dataManager";

test.describe("Customer Registration and Login", () => {
    test("Customer register on ShopFront", async ({ page }) => {
        const randomID = Date.now();

        const customerCredentials = {
            first_name: "Customer",
            last_name: `Customer ${randomID}`,
            email: generateEmail(),
            password: "admin123",
        };

        const customerRegisterPage = new CustomerRegisterLogin(page);
        await customerRegisterPage.customerRegisterPageGoto();

        await customerRegisterPage.customerRegister(
            customerCredentials.first_name,
            customerCredentials.last_name,
            customerCredentials.email,
            customerCredentials.password,
        );
        saveData("customer", customerCredentials);
        
    });

    test("customer should login with valid credentials", async ({ page }) => {
        const customerLoginCredentials = readData("customer")
        console.log(customerLoginCredentials);
        

        const customerLoginPage = new CustomerRegisterLogin(page);
        await customerLoginPage.customerLoginPageGoto();
        
        await customerLoginPage.customerLogin(
            customerLoginCredentials.email,
            customerLoginCredentials.password,
        );

        await page.waitForURL("");

        await expect(page).toHaveURL("");
    });
});
