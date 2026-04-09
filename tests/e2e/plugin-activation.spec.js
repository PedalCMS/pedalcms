const { test, expect } = require('@playwright/test');
const { loginAsAdmin, ensurePluginIsActive } = require('./helpers/wp-admin');

test.describe('PedalCMS plugin activation', () => {
  test('plugin can be activated from plugins screen', async ({ page }) => {
    await loginAsAdmin(page);
    await ensurePluginIsActive(page);

    await page.goto('/wp-admin/plugins.php');

    const pluginRow = page.locator('tr[data-slug="pedalcms"]');
    await expect(pluginRow).toBeVisible();
    await expect(pluginRow).toContainText('Pedal CMS');
    await expect(pluginRow.getByRole('link', { name: 'Settings' })).toBeVisible();
  });
});
