import { defineConfig, devices } from "@playwright/test";
import dotenv from "dotenv";
import fs from "fs";
import path from "path";
import { fileURLToPath } from "url";

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

export const TESTS_ROOT_PATH = __dirname;
export const STATE_DIR_PATH = `${ TESTS_ROOT_PATH }/.state/`;
export const ADMIN_AUTH_STATE_PATH = `${ STATE_DIR_PATH }/admin-auth.json`;

const BAGISTO_PATH = process.env.BAGISTO_PATH || (() => {
    let dir = __dirname;

    for (;;) {
        if (
            fs.existsSync(path.join(dir, "artisan"))
            && fs.existsSync(path.join(dir, "public"))
        ) {
            return dir;
        }

        const parent = path.dirname(dir);

        if (parent === dir) {
            throw new Error(
                `playwright: could not locate the Laravel application root above "${__dirname}". `
                + "Set BAGISTO_PATH to the application path."
            );
        }

        dir = parent;
    }
})();

dotenv.config({ path: path.join(BAGISTO_PATH, ".env") });

export default defineConfig({
    testDir: "./tests",

    timeout: 300 * 1000,

    expect: { timeout: 30 * 1000 },

    outputDir: "./test-results",

    fullyParallel: false,

    workers: 1,

    forbidOnly: !!process.env.CI,

    retries: 0,

    reportSlowTests: null,

    reporter: [
        ["list"],
        
        [
            "html",
            {
                outputFolder: "./playwright-report",
            },
        ],
    ],

    use: {
        baseURL: `${process.env.APP_URL}/`.replace(/\/+$/, "/"),
        screenshot: { mode: "only-on-failure", fullPage: true },
        video: "retain-on-failure",
        trace: "retain-on-failure",
    },

    projects: [
        {
            name: "chromium",
            use: { ...devices["Desktop Chrome"] },
        },
    ],
});