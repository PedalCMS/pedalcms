const { test, expect } = require('@playwright/test');
const { openPedalSettings } = require('./helpers/wp-admin');

test.describe('PedalCMS settings tabs', () => {
  test('all expected tabs are visible', async ({ page }) => {
    await openPedalSettings(page);

    await expect(page.getByText('General')).toBeVisible();
    await expect(page.getByText('Programs')).toBeVisible();
    await expect(page.getByText('Subpages')).toBeVisible();
    await expect(page.getByText('Course Catalog')).toBeVisible();
    await expect(page.getByText('Directory')).toBeVisible();
    await expect(page.getByText('Taxonomies')).toBeVisible();
  });
});
