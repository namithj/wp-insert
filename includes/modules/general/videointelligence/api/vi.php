<?php
function wp_insert_vi_api_get_settings() {
	$vi_settings = get_transient( 'wp_insert_vi_api_settings' );
	if ( ( false === $vi_settings ) || ! is_array( $vi_settings ) ) {
		try {
			$response = wp_remote_get( 'https://dashboard-api.vidint.net/v1/api/widget/settings', [ 'timeout' => 15 ] );
			if ( ! is_wp_error( $response ) && ( 200 === wp_remote_retrieve_response_code( $response ) ) ) {
				$response_body = json_decode( $response['body'] );
				if ( ( JSON_ERROR_NONE === json_last_error() ) && ( 'ok' === $response_body->status ) ) {
					$vi_settings = [
						'signupURL'           => $response_body->data->signupURL,
						'demoPageURL'         => $response_body->data->demoPageURL,
						'iabCategoriesURL'    => $response_body->data->iabCategoriesURL,
						'loginAPI'            => $response_body->data->loginAPI,
						'directSellURL'       => $response_body->data->directSellURL,
						'dashboardURL'        => $response_body->data->dashboardURL,
						'revenueAPI'          => $response_body->data->revenueAPI,
						'adsTxtAPI'           => $response_body->data->adsTxtAPI,
						'languages'           => $response_body->data->languages,
						'jsTagAPI'            => $response_body->data->jsTagAPI,
						'vendorListURL'       => $response_body->data->vendorListURL,
						'vendorListVersion'   => $response_body->data->vendorListVersion,
						'consentPopupContent' => $response_body->data->consentPopupContent,
						'purposes'            => $response_body->data->purposes,
					];
					delete_transient( 'wp_insert_vi_api_settings' );
					set_transient( 'wp_insert_vi_api_settings', $vi_settings, WEEK_IN_SECONDS );
				} else {
					return false;
				}
			}
		} catch ( Exception $ex ) {
			return false;
		}
	}
	return $vi_settings;
}

function wp_insert_vi_api_reset_settings() {
	delete_transient( 'wp_insert_vi_api_settings' );
}

function wp_insert_vi_api_get_signupurl() {
	$vi_settings = wp_insert_vi_api_get_settings();
	if ( ( false !== $vi_settings ) && is_array( $vi_settings ) ) {
		return $vi_settings['signupURL'];
	}
	return false;
}

function wp_insert_vi_api_get_dashboardurl() {
	$vi_settings = wp_insert_vi_api_get_settings();
	if ( ( false !== $vi_settings ) && is_array( $vi_settings ) ) {
		return $vi_settings['dashboardURL'];
	}
	return false;
}

function wp_insert_vi_api_get_iab_categories_url() {
	$vi_settings = wp_insert_vi_api_get_settings();
	if ( ( false !== $vi_settings ) && is_array( $vi_settings ) ) {
		return $vi_settings['iabCategoriesURL'];
	}
	return false;
}

function wp_insert_vi_api_get_languages() {
	$vi_settings = wp_insert_vi_api_get_settings();
	if ( ( false !== $vi_settings ) && is_array( $vi_settings ) ) {
		$languages = [];
		foreach ( $vi_settings['languages'] as $language ) {
			foreach ( $language as $key => $value ) {
				$languages[ $key ] = $value;
			}
		}
		if ( count( $languages ) > 0 ) {
			return $languages;
		} else {
			return false;
		}
	}
	return false;
}

function wp_insert_vi_api_get_consent_popup_content() {
	$vi_settings = wp_insert_vi_api_get_settings();
	if ( ( false !== $vi_settings ) && is_array( $vi_settings ) ) {
		return $vi_settings['consentPopupContent'];
	}
	return false;
}

function wp_insert_vi_api_get_consent_purposes() {
	$vi_settings = wp_insert_vi_api_get_settings();
	if ( ( false !== $vi_settings ) && is_array( $vi_settings ) ) {
		return $vi_settings['purposes'];
	}
	return false;
}

function wp_insert_vi_api_get_adstxt_content() {
	$vi_settings = wp_insert_vi_api_get_settings();
	if ( ( false !== $vi_settings ) && is_array( $vi_settings ) ) {
		$vi_token = wp_insert_vi_api_get_publisher_token();
		if ( false !== $vi_token ) {
			try {
				$response = wp_remote_get(
					$vi_settings['adsTxtAPI'],
					[
						'timeout' => 15,
						'headers' => [
							'Content-Type'  => 'application/json',
							'Authorization' => $vi_token,
						],
					]
				);
				if ( ! is_wp_error( $response ) ) {
					if ( 200 === wp_remote_retrieve_response_code( $response ) ) {
						$response_body = json_decode( $response['body'] );
						if ( ( JSON_ERROR_NONE === json_last_error() ) && ( 'ok' === $response_body->status ) ) {
							return $response_body->data;
						} else {
							return false;
						}
					} else {
						return false;
					}
				}
			} catch ( Exception $ex ) {
				return false;
			}
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function wp_insert_vi_api_login( $email, $password ) {
	if ( ( '' !== $email ) && ( '' !== $password ) ) {
		$vi_settings = wp_insert_vi_api_get_settings();
		if ( ( false !== $vi_settings ) && is_array( $vi_settings ) ) {
			try {
				$response = wp_remote_post(
					$vi_settings['loginAPI'],
					[
						'timeout' => 15,
						'headers' => [
							'Content-Type' => 'application/json',
						],
						'body'    => wp_json_encode(
							[
								'email'    => $email,
								'password' => $password,
							]
						),
					]
				);
				if ( ! is_wp_error( $response ) ) {
					if ( 401 === wp_remote_retrieve_response_code( $response ) ) {
						$response_body = json_decode( $response['body'] );
						if ( ( JSON_ERROR_NONE === json_last_error() ) && ( 'error' === $response_body->status ) ) {
							return [
								'status'    => 'error',
								'errorCode' => 'WIVI008',
								'message'   => $response_body->error->message . ':' . $response_body->error->description . '',
							];
						} else {
							return [
								'status'    => 'error',
								'errorCode' => 'WIVI007',
								'message'   => 'Response JSON error, Please try again later!',
							];
						}
					} elseif ( 200 === wp_remote_retrieve_response_code( $response ) ) {
						$response_body = json_decode( $response['body'] );
						if ( ( JSON_ERROR_NONE === json_last_error() ) && ( 'ok' === $response_body->status ) ) {
							$vi_token = $response_body->data;
							delete_transient( 'wp_insert_vi_api_authetication_token' );
							set_transient( 'wp_insert_vi_api_authetication_token', $vi_token, MONTH_IN_SECONDS );
						} else {
							return [
								'status'    => 'error',
								'errorCode' => 'WIVI006',
								'message'   => 'Response JSON error!',
							];
						}
					} else {
						return [
							'status'    => 'error',
							'errorCode' => 'WIVI005',
							'message'   => 'Unknown response code',
						];
					}
				} else {
					return [
						'status'    => 'error',
						'errorCode' => 'WIVI004',
						'message'   => 'API response error',
					];
				}
			} catch ( Exception $ex ) {
				return [
					'status'    => 'error',
					'errorCode' => 'WIVI003',
					'message'   => 'Exception during API communication',
				];
			}
		} else {
			return [
				'status'    => 'error',
				'errorCode' => 'WIVI002',
				'message'   => 'API is unreachable',
			];
		}
	} else {
		return [
			'status'    => 'error',
			'errorCode' => 'WIVI001',
			'message'   => 'Email / Password is Empty!',
		];
	}
	return $vi_token;
}

function wp_insert_vi_api_logout() {
	delete_transient( 'wp_insert_vi_api_authetication_token' );
}

function wp_insert_vi_api_get_publisher_id() {
	$vi_token = get_transient( 'wp_insert_vi_api_authetication_token' );
	if ( false === $vi_token ) {
		return false;
	}
	$vi_token = explode( '.', $vi_token );
	$vi_token = base64_decode( $vi_token[1] ); // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_decode
	$vi_token = json_decode( $vi_token );
	if ( JSON_ERROR_NONE === json_last_error() ) {
		return $vi_token->publisherId; // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
	}
	return false;
}

function wp_insert_vi_api_get_publisher_token() {
	$vi_token = get_transient( 'wp_insert_vi_api_authetication_token' );
	if ( false === $vi_token ) {
		return false;
	}
	return $vi_token;
}

function wp_insert_vi_api_is_loggedin() {
	$vi_token = get_transient( 'wp_insert_vi_api_authetication_token' );
	if ( false === $vi_token ) {
		return false;
	}
	return true;
}

function wp_insert_vi_api_get_revenue_data() {
	$vi_settings = wp_insert_vi_api_get_settings();
	if ( ( false !== $vi_settings ) && is_array( $vi_settings ) ) {
		$vi_token = wp_insert_vi_api_get_publisher_token();
		if ( false !== $vi_token ) {
			try {
				$response = wp_remote_get(
					$vi_settings['revenueAPI'],
					[
						'timeout' => 15,
						'headers' => [
							'Content-Type'  => 'application/json',
							'Authorization' => $vi_token,
						],
					]
				);
				if ( ! is_wp_error( $response ) ) {
					if ( 200 === wp_remote_retrieve_response_code( $response ) ) {
						$response_body = json_decode( $response['body'] );
						if ( ( JSON_ERROR_NONE === json_last_error() ) && ( 'ok' === $response_body->status ) ) {
							return json_decode( wp_json_encode( $response_body->data ), true );
						} else {
							return false;
						}
					} else {
						return false;
					}
				}
			} catch ( Exception $ex ) {
				return false;
			}
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function wp_insert_vi_api_set_vi_code( $args = null ) {
	$domain                  = wp_insert_get_domain_name_from_url( get_bloginfo( 'url' ) );
	$selected_args           = [];
	$selected_args['domain'] = $domain;
	$selected_args['divId']  = 'wp_insert_vi_ad';

	if ( isset( $args ) && is_array( $args ) ) {
		if ( isset( $args['ad_unit_type'] ) && ( '' !== $args['ad_unit_type'] ) && ( 'select' !== $args['ad_unit_type'] ) && ( 'undefined' !== $args['ad_unit_type'] ) ) {
			$selected_args['adUnitType'] = $args['ad_unit_type'];
		} else {
			$selected_args['adUnitType'] = 'NATIVE_VIDEO_UNIT';
		}

		if ( isset( $args['language'] ) && ( '' !== $args['language'] ) && ( 'select' !== $args['language'] ) && ( 'undefined' !== $args['language'] ) ) {
			$selected_args['language'] = $args['language'];
		}

		if ( isset( $args['iab_category_child'] ) && ( '' !== $args['iab_category_child'] ) && ( 'select' !== $args['iab_category_child'] ) && ( 'undefined' !== $args['iab_category_child'] ) ) {
			$selected_args['iabCategory'] = $args['iab_category_child'];
		}

		if ( isset( $args['font_family'] ) && ( '' !== $args['font_family'] ) && ( 'select' !== $args['font_family'] ) && ( 'undefined' !== $args['font_family'] ) ) {
			$selected_args['font'] = $args['font_family'];
		}

		if ( isset( $args['font_size'] ) && ( '' !== $args['font_size'] ) && ( 'select' !== $args['font_size'] ) && ( 'undefined' !== $args['font_size'] ) ) {
			$selected_args['fontSize'] = $args['font_size'];
		}

		if ( isset( $args['keywords'] ) && ( '' !== $args['keywords'] ) && ( 'undefined' !== $args['keywords'] ) ) {
			$selected_args['keywords'] = $args['keywords'];
		} else { //Send the keywords field even if it is empty
			$selected_args['keywords'] = '';
		}

		if ( isset( $args['native_text_color'] ) && ( '' !== $args['native_text_color'] ) && ( 'undefined' !== $args['native_text_color'] ) ) {
			$selected_args['textColor'] = $args['native_text_color'];
		}

		if ( isset( $args['native_bg_color'] ) && ( '' !== $args['native_bg_color'] ) && ( 'undefined' !== $args['native_bg_color'] ) ) {
			$selected_args['backgroundColor'] = $args['native_bg_color'];
		}
	}

	$vi_settings = wp_insert_vi_api_get_settings();
	if ( ( false !== $vi_settings ) && is_array( $vi_settings ) ) {
		$vi_token = wp_insert_vi_api_get_publisher_token();
		if ( false !== $vi_token ) {
			try {
				$response = wp_remote_request(
					$vi_settings['jsTagAPI'],
					[
						'method'  => 'POST',
						'timeout' => 15,
						'headers' => [
							'Content-Type'  => 'application/json',
							'Authorization' => $vi_token,
						],
						'body'    => wp_json_encode( $selected_args ),
					]
				);
				if ( ! is_wp_error( $response ) ) {
					if ( 400 === wp_remote_retrieve_response_code( $response ) ) {
						$response_body = json_decode( $response['body'] );
						if ( ( JSON_ERROR_NONE === json_last_error() ) && ( 'error' === $response_body->status ) ) {
							return [
								'status'    => 'error',
								'errorCode' => 'WIVI108',
								'message'   => $response_body->error->description,
							];
						} else {
							return [
								'status'    => 'error',
								'errorCode' => 'WIVI107',
								'message'   => 'Response JSON error, Please try again later!',
							];
						}
					} elseif ( 201 === wp_remote_retrieve_response_code( $response ) ) {
						$response_body = json_decode( $response['body'] );
						if ( ( JSON_ERROR_NONE === json_last_error() ) && ( 'ok' === $response_body->status ) ) {
							delete_transient( 'wp_insert_vi_api_jstag' );
							set_transient( 'wp_insert_vi_api_jstag', $response_body->data, YEAR_IN_SECONDS );
							return $response_body->data;
						} else {
							return [
								'status'    => 'error',
								'errorCode' => 'WIVI106',
								'message'   => 'Response JSON error!',
							];
						}
					} else {
						return [
							'status'    => 'error',
							'errorCode' => 'WIVI105',
							'message'   => 'Unknown response code',
						];
					}
				}
			} catch ( Exception $ex ) {
				return [
					'status'    => 'error',
					'errorCode' => 'WIVI103',
					'message'   => 'Exception during API communication',
				];
			}
		} else {
			return [
				'status'    => 'error',
				'errorCode' => 'WIVI102',
				'message'   => 'Authorization Token is Missing',
			];
		}
	} else {
		return [
			'status'    => 'error',
			'errorCode' => 'WIVI101',
			'message'   => 'API is unreachable',
		];
	}
}

function wp_insert_vi_api_get_vi_code( $settings_key = '' ) {
	$js_tag = get_transient( 'wp_insert_vi_api_jstag' );
	if ( ( false === $js_tag ) || ( '' === $js_tag ) || is_array( $js_tag ) ) {
		if ( '' !== $settings_key ) {
			$vicode_settings = get_option( $settings_key );
			$js_tag          = wp_insert_vi_api_set_vi_code( $vicode_settings );
		} else {
			$js_tag = wp_insert_vi_api_set_vi_code();
		}
		if ( ( false === $js_tag ) || ( '' === $js_tag ) || is_array( $js_tag ) ) {
			return false;
		}
	}
	return '<script type="text/javascript">' . $js_tag . '</script>';
}

function wp_insert_vi_api_is_eu() {
	$user_ip = $_SERVER['REMOTE_ADDR'];
	$is_eu   = get_transient( 'wp_insert_vi_api_is_eu_' . $user_ip );
	if ( false === $is_eu ) {
		try {
			$response = wp_remote_get(
				'http://gdpr-check.net/gdpr/is-eu?ip=' . $user_ip,
				[ 'timeout' => 15 ]
			);
			if ( ! is_wp_error( $response ) ) {
				if ( 200 === wp_remote_retrieve_response_code( $response ) ) {
					$response_body = json_decode( $response['body'] );
					if ( ( JSON_ERROR_NONE === json_last_error() ) ) {
						if ( ( isset( $response_body->is_eu ) ) && ( '1' === $response_body->is_eu ) ) {
							delete_transient( 'wp_insert_vi_api_is_eu_' . $user_ip );
							set_transient( 'wp_insert_vi_api_is_eu_' . $user_ip, '1', WEEK_IN_SECONDS );
							return true;
						} else {
							delete_transient( 'wp_insert_vi_api_is_eu_' . $user_ip );
							set_transient( 'wp_insert_vi_api_is_eu_' . $user_ip, '0', WEEK_IN_SECONDS );
							return false;
						}
					} else {
						return false;
					}
				} else {
					return false;
				}
			}
		} catch ( Exception $ex ) {
			return false;
		}
	} elseif ( '1' === $is_eu ) {
			return true;
	} else {
		return false;
	}
}

function wp_insert_vi_api_get_vendor_list_version() {
	$vi_settings = wp_insert_vi_api_get_settings();
	if ( ( false !== $vi_settings ) && is_array( $vi_settings ) ) {
		return $vi_settings['vendorListVersion'];
	}
	return false;
}
