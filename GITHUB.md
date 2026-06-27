# PersiaPro — GitHub Releases & Auto-Updates

This project supports **one-click theme updates** in WordPress via GitHub Releases.

## Repository setup

1. Create a GitHub repository named `persiapro` under your account (`kiaksar`)
2. Push this project:

```bash
cd "/Users/kiamt01/Desktop/Shahrabi Sag"
git init
git add .
git commit -m "Initial PersiaPro theme release"
git branch -M main
git remote add origin https://github.com/kiaksar/persiapro.git
git push -u origin main
```

## Publishing a new version

1. Bump version in:
   - `persiapro/style.css` (Version header)
   - `persiapro/functions.php` (`PERSIAPRO_VERSION`)

2. Commit and tag:

```bash
git add .
git commit -m "Release v1.2.0"
git tag v1.2.0
git push origin main --tags
```

3. GitHub Actions (`.github/workflows/release.yml`) automatically:
   - Builds `persiapro.zip` from the `persiapro/` folder
   - Attaches it to the GitHub Release

4. WordPress sites with the theme installed will see **Dashboard → Updates** (or **Appearance → Themes**) when a newer tag exists.

## WordPress update flow

The theme checks:

`https://api.github.com/repos/kiaksar/persiapro/releases/latest`

When the release tag (e.g. `v1.2.0`) is newer than the installed version, WordPress offers an update using the `persiapro.zip` release asset.

## Customize GitHub account / repo

Default author: **kiaksar** — change via filter in a child theme or mu-plugin:

```php
add_filter( 'persiapro_github_user', fn() => 'your-github-username' );
add_filter( 'persiapro_github_repo', fn() => 'your-repo-name' );
```

For **private repositories**, add a GitHub personal access token:

```php
add_filter( 'persiapro_github_token', fn() => 'ghp_xxxxxxxxxxxx' );
```

## Materials title — where to customize

Three ways:

1. **Appearance → PersiaPro** (recommended) → **Homepage — Materials Section** → **Customize**
2. **Appearance → Customize → PersiaPro Homepage → Homepage — Materials Section**
3. **Themes → PersiaPro → PersiaPro Settings** link

Edit **Section Title** for the materials heading (default: `مواد و محصولات ما`).
