import { Locator } from "@playwright/test";

export async function ensureToggleState(locator: Locator, shouldBeChecked: boolean) {
    // Try checkbox first
    const isChecked = await locator.isChecked();
    try {
      if (isChecked !== shouldBeChecked) {
        await locator.click();
      }
    } catch {
      // Fallback if it's not a real checkbox
      // const ariaChecked = await locator.getAttribute('aria-checked');
      // const isChecked = ariaChecked === 'true';

      if (isChecked !== shouldBeChecked) {
        await locator.click();
      }
    }
  }

