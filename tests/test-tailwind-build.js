const { execSync } = require('child_process');
const fs = require('fs');
const path = require('path');

const outputDir = path.join(__dirname, '../assets/css/dist');
const outputFile = path.join(outputDir, 'test-build.css');
const inputFile = path.join(__dirname, '../assets/css/src/style.css');

// Ensure output dir exists
if (!fs.existsSync(outputDir)) {
    fs.mkdirSync(outputDir, { recursive: true });
}

function runTest() {
    console.log('Running Tailwind Test Build...');
    try {
        // Run tailwind build to a temporary file
        execSync(`npx tailwindcss -i ${inputFile} -o ${outputFile}`);
        
        const css = fs.readFileSync(outputFile, 'utf8');
        
        const checks = [
            { name: 'Primary Color Variable', pattern: /var\(--ak-primary-color\)/ },
            { name: 'Accent Gold Variable', pattern: /var\(--ak-accent-gold\)/ },
            { name: 'Site BG Variable', pattern: /var\(--ak-site-bg\)/ },
            { name: 'Header BG Variable', pattern: /var\(--ak-header-bg\)/ },
            { name: 'Footer BG Variable', pattern: /var\(--ak-footer-bg\)/ },
            { name: 'Body Text Variable', pattern: /var\(--ak-body-text\)/ },
            { name: 'Heading Text Variable', pattern: /var\(--ak-heading-text\)/ },
            { name: 'Link Color Variable', pattern: /var\(--ak-link-color\)/ },
            { name: 'Link Hover Variable', pattern: /var\(--ak-link-hover-color\)/ }
        ];

        let failed = false;
        checks.forEach(check => {
            if (check.pattern.test(css)) {
                console.log(`PASS: ${check.name} found in CSS.`);
            } else {
                console.log(`FAIL: ${check.name} NOT found in CSS.`);
                failed = true;
            }
        });

        if (failed) {
            process.exit(1);
        }
    } catch (error) {
        console.error('Error during build or test:', error.message);
        process.exit(1);
    } finally {
        if (fs.existsSync(outputFile)) {
            fs.unlinkSync(outputFile);
        }
    }
}

runTest();
