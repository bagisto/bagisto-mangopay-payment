import { Locator, Page } from "@playwright/test";
import { ensureToggleState } from "../../utils/ensuretoggle";

export class MangoPayConfigurationPage {
readonly page: Page;

readonly saveButton: Locator;

readonly titleInput: Locator;
readonly descriptionInput: Locator;
readonly clientIdInput: Locator;
readonly passphraseInput: Locator;
readonly sortOrderInput: Locator;

readonly statusToggle: Locator;
readonly sandboxToggle: Locator;

readonly configurationSuccessmessagepage: Locator;

constructor(page: Page) {
this.page = page;

this.statusToggle = page.locator(
  'label.relative:has(input[id="sales[payment_methods][mangopay_standard][active]"])'
).first();


this.titleInput = page.getByRole("textbox", {
  name: "Title * English",
});

this.descriptionInput = page.locator(
  '[id="sales[payment_methods][mangopay_standard][description]"]',
);

this.clientIdInput = page.getByRole("textbox", {
  name: "Client ID * English",
});

this.passphraseInput = page.getByRole("textbox", {
  name: "Passphrase * English",
});

this.sandboxToggle = page.locator(
  "div:nth-child(14) > .mb-4 > .relative > .peer.h-5",
);

this.sortOrderInput = page.getByRole("spinbutton", {
  name: "Sort Order",
  exact: true,
});

this.saveButton = page.getByRole("button", {
  name: "Save Configuration",
});

this.configurationSuccessmessagepage = page
  .locator("#app")
  .getByText("Configuration saved");

}

async navigateToMangoPayPaymentMethodConfiguration() {
  await this.page.goto(`${process.env.APP_ADMIN_URL || "admin"}/configuration/sales/payment_methods`);
}

async enableMangoPayPaymentMethod() {
  const isEnable = this.page.locator('input[type="checkbox"]').nth(3);
  if (!(await isEnable.isChecked())) 
  {
      await isEnable.check({ force: true }); 
  }
}


async configureMangoPayPaymentMethod(
  title: string,
  description: string,
  clientId: string,
  passphrase: string,
  ) {
    console.log("jghslose",
    await this.statusToggle.evaluate((el) => el.outerHTML)
  );
    await this.enableMangoPayPaymentMethod();

    await this.titleInput.fill(title);
    await this.descriptionInput.fill(description);
    await this.clientIdInput.fill(clientId);
    await this.passphraseInput.fill(passphrase);

    await this.saveButton.click();
  }
}
