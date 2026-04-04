async function loginAsAdmin(page) {
  const username = process.env.E2E_ADMIN_USER || 'admin';
  const password = process.env.E2E_ADMIN_PASSWORD || 'password';

  await page.goto('/wp-login.php');

  if (await page.locator('#loginform').isVisible()) {
    await page.fill('#user_login', username);
    await page.fill('#user_pass', password);
    await page.click('#wp-submit');
  }

  await page.waitForURL(/wp-admin|wp-login.php/);
}

async function ensurePluginIsActive(page, pluginSlug = process.env.E2E_PLUGIN_SLUG || 'pedalcms') {
  await loginAsAdmin(page);
  await page.goto('/wp-admin/plugins.php');

  const pluginRow = page.locator(`tr[data-slug="${pluginSlug}"]`);
  await pluginRow.waitFor();

  const activateLink = pluginRow.getByRole('link', { name: 'Activate' });
  if (await activateLink.count()) {
    await activateLink.first().click();
    await page.waitForLoadState('networkidle');
  }
}

async function openPedalSettings(page) {
  await loginAsAdmin(page);
  await ensurePluginIsActive(page);
  await page.goto('/wp-admin/edit.php?post_type=pdl_program&page=pedalcms-settings');
}

module.exports = {
  loginAsAdmin,
  ensurePluginIsActive,
  openPedalSettings,
};
