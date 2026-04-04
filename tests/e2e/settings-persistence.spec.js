const { test, expect } = require('@playwright/test');
const { openPedalSettings } = require('./helpers/wp-admin');

test.describe('PedalCMS settings persistence', () => {
  test('general settings save and persist', async ({ page }) => {
    await openPedalSettings(page);

    await expect(page).toHaveURL(/pedalcms-settings/);

    const fullMode = page.locator('input[type="radio"][value="full"]');
    if (await fullMode.count()) {
      await fullMode.first().check();
    }

    const activeColor = page.locator('input[type="color"][name*="active_color"]').first();
    if (await activeColor.count()) {
      await activeColor.fill('#123456');
    }

    const buttonTextColor = page.locator('input[type="color"][name*="active_color_text"]').first();
    if (await buttonTextColor.count()) {
      await buttonTextColor.fill('#ffffff');
    }

    const saveButton = page.locator('button[type="submit"], input[type="submit"]').first();
    await saveButton.click();

    await page.waitForLoadState('networkidle');

    if (await activeColor.count()) {
      await expect(activeColor).toHaveValue('#123456');
    }
  });
});
