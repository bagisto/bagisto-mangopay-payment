const ADMIN_URL = process.env.APP_ADMIN_URL || "admin";

export async function loginAsAdmin(page) {
    /**
     * Admin credentials.
     */
    const adminCredentials = {
        email: "admin@example.com",
        password: "admin123",
    };

    /**
     * Authenticate the admin user.
     */
    await page.goto(`${ADMIN_URL}/login`);
    await page.fill('input[name="email"]', adminCredentials.email);
    await page.fill('input[name="password"]', adminCredentials.password);
    await page.press('input[name="password"]', "Enter");

    /**
     * Wait for the dashboard to load.
     */
    await page.waitForURL(`**/${ADMIN_URL}/dashboard`);

    return adminCredentials;
}
