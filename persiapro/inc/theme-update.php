<?php
/**
 * GitHub-based theme update checker.
 *
 * @package PersiaPro
 * @since 1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * GitHub username for updates and theme metadata.
 *
 * @return string
 */
function persiapro_github_user() {
	return apply_filters( 'persiapro_github_user', 'kiaksar' );
}

/**
 * GitHub repository name (without user).
 *
 * @return string
 */
function persiapro_github_repo() {
	return apply_filters( 'persiapro_github_repo', 'persiapro' );
}

/**
 * Fetch latest release data from GitHub.
 *
 * @return object|null
 */
function persiapro_get_github_release() {
	$user = persiapro_github_user();
	$repo = persiapro_github_repo();

	if ( empty( $user ) || empty( $repo ) ) {
		return null;
	}

	$cache_key = 'persiapro_github_release';
	$cached    = get_transient( $cache_key );

	if ( false !== $cached ) {
		return $cached ? json_decode( $cached ) : null;
	}

	$url = sprintf( 'https://api.github.com/repos/%s/%s/releases/latest', rawurlencode( $user ), rawurlencode( $repo ) );

	$args = array(
		'timeout' => 15,
		'headers' => array(
			'Accept'     => 'application/vnd.github+json',
			'User-Agent' => 'PersiaPro-WordPress-Theme/' . PERSIAPRO_VERSION,
		),
	);

	$token = apply_filters( 'persiapro_github_token', '' );
	if ( ! empty( $token ) ) {
		$args['headers']['Authorization'] = 'Bearer ' . $token;
	}

	$response = wp_remote_get( $url, $args );

	if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
		set_transient( $cache_key, '', HOUR_IN_SECONDS );
		return null;
	}

	$body = wp_remote_retrieve_body( $response );
	set_transient( $cache_key, $body, 12 * HOUR_IN_SECONDS );

	return json_decode( $body );
}

/**
 * Get download URL for persiapro.zip from release assets.
 *
 * @param object $release GitHub release object.
 * @return string
 */
function persiapro_get_release_download_url( $release ) {
	if ( empty( $release->assets ) ) {
		return '';
	}

	foreach ( $release->assets as $asset ) {
		if ( isset( $asset->name ) && 'persiapro.zip' === $asset->name ) {
			return $asset->browser_download_url;
		}
	}

	return '';
}

/**
 * Normalize version string from GitHub tag.
 *
 * @param string $tag Tag name.
 * @return string
 */
function persiapro_normalize_version( $tag ) {
	return ltrim( $tag, 'vV' );
}

/**
 * Check GitHub for theme updates.
 *
 * @param object $transient Update transient.
 * @return object
 */
function persiapro_check_theme_update( $transient ) {
	if ( empty( $transient->checked ) ) {
		return $transient;
	}

	$release = persiapro_get_github_release();
	if ( ! $release || empty( $release->tag_name ) ) {
		return $transient;
	}

	$remote_version = persiapro_normalize_version( $release->tag_name );
	$local_version  = PERSIAPRO_VERSION;

	if ( version_compare( $local_version, $remote_version, '>=' ) ) {
		return $transient;
	}

	$package = persiapro_get_release_download_url( $release );

	$transient->response['persiapro'] = array(
		'theme'       => 'persiapro',
		'new_version' => $remote_version,
		'url'         => isset( $release->html_url ) ? $release->html_url : 'https://github.com/' . persiapro_github_user() . '/' . persiapro_github_repo(),
		'package'     => $package,
	);

	return $transient;
}
add_filter( 'pre_set_site_transient_update_themes', 'persiapro_check_theme_update' );

/**
 * Provide theme details on the updates screen.
 *
 * @param false|object|array $result Result.
 * @param string             $action Action type.
 * @param object             $args   Arguments.
 * @return false|object
 */
function persiapro_theme_update_info( $result, $action, $args ) {
	if ( 'theme_information' !== $action || empty( $args->slug ) || 'persiapro' !== $args->slug ) {
		return $result;
	}

	$release = persiapro_get_github_release();
	if ( ! $release ) {
		return $result;
	}

	$user = persiapro_github_user();

	return (object) array(
		'name'          => 'PersiaPro',
		'slug'          => 'persiapro',
		'version'       => persiapro_normalize_version( $release->tag_name ),
		'author'        => '<a href="https://github.com/' . esc_attr( $user ) . '">' . esc_html( $user ) . '</a>',
		'homepage'      => 'https://github.com/' . $user . '/' . persiapro_github_repo(),
		'download_link' => persiapro_get_release_download_url( $release ),
		'sections'      => array(
			'description' => wp_kses_post( $release->body ?? '' ),
			'changelog'   => wp_kses_post( $release->body ?? '' ),
		),
	);
}
add_filter( 'themes_api', 'persiapro_theme_update_info', 10, 3 );

/**
 * Allow GitHub release asset downloads (optional token for private repos).
 *
 * @param array  $args Request args.
 * @param string $url  Request URL.
 * @return array
 */
function persiapro_github_download_headers( $args, $url ) {
	if ( false !== strpos( $url, 'github.com' ) ) {
		$token = apply_filters( 'persiapro_github_token', '' );
		if ( ! empty( $token ) ) {
			$args['headers']['Authorization'] = 'Bearer ' . $token;
		}
		$args['headers']['Accept'] = 'application/octet-stream';
	}
	return $args;
}
add_filter( 'http_request_args', 'persiapro_github_download_headers', 10, 2 );

/**
 * Clear GitHub release cache after upgrade.
 */
function persiapro_clear_update_cache() {
	delete_transient( 'persiapro_github_release' );
}
add_action( 'upgrader_process_complete', 'persiapro_clear_update_cache', 10, 0 );
