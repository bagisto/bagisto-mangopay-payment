import fs from "fs";
import path from "path";
import { fileURLToPath } from "url";

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const DIR = path.resolve(__dirname, "../test-data");

function ensureDir() {
    if (!fs.existsSync(DIR)) {
        fs.mkdirSync(DIR, { recursive: true });
    }
}

export function saveData(fileName: string, data: any) {
    ensureDir();
    fs.writeFileSync(
        `${DIR}/${fileName}.json`,
        JSON.stringify(data, null, 2)
    );
}

export function readData(fileName: string) {
    const filePath = `${DIR}/${fileName}.json`;
    if (!fs.existsSync(filePath)) {
        return null;
    }

    return JSON.parse(fs.readFileSync(filePath, "utf-8"));
}


