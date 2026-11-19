<?php
/**
 * What a Form block does when it is submitted: who gets the email, which services are called, whether
 * reCAPTCHA is required.
 *
 * These settings belong to whoever saved the block, so the submit handler must never read them from the
 * request. The page prints them sealed (encrypted and authenticated with a key only this site has), the
 * script sends the sealed string back unchanged, and the handler opens it. That works wherever the block
 * lives (a post, a template, a widget, a pattern) and keeps custom API keys out of the page source.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class PBG_Form_Config
 */
class PBG_Form_Config {

	/**
	 * The submit actions the handler knows. The editor saves FluentCRM under "fluentcrm".
	 */
	const ACTIONS = array( 'sendEmail', 'mailchimp', 'mailerlite', 'fluentcrm' );

	/**
	 * Attributes the frontend script must never receive: API keys, and the recipient addresses,
	 * which the script does not use and which would otherwise be in the page source.
	 */
	const SECRET_ATTRIBUTES = array( 'mailchimpApiKey', 'mailerliteApiToken', 'fluentcrmApiToken', 'toEmail', 'ccEmail', 'bccEmail' );

	/**
	 * The settings the submit handler acts on, taken from the block's saved attributes.
	 *
	 * @param array $attributes Block attributes, with block.json defaults applied.
	 * @param array $binding    Where the form was rendered, so a config can not outlive or leave its form:
	 *                          - blockId: the id the page prints the form under. The request must name the same form.
	 *                          - draft:   the form is in content that is not published. A Contributor can preview
	 *                                     their own draft, so the handler accepts it only from users who can publish.
	 *                          - postId, content: the post whose content holds the form, and a hash of that content.
	 *                                     The handler refuses the config once that post is edited or unpublished.
	 *                                     0 and '' for a form in a template, a widget or a synced pattern.
	 *
	 * @return array
	 */
	public static function from_attributes( array $attributes, array $binding = array() ) {
		$actions = isset( $attributes['submitActions'] ) && is_array( $attributes['submitActions'] ) ? $attributes['submitActions'] : array();
		$enabled = array();

		foreach ( self::ACTIONS as $action ) {
			$enabled[ $action ] = ! empty( $actions[ $action ] );
		}

		return array(
			'blockId'       => self::text( $binding, 'blockId' ),
			'draft'         => ! empty( $binding['draft'] ),
			'postId'        => isset( $binding['postId'] ) ? max( 0, (int) $binding['postId'] ) : 0,
			'content'       => self::text( $binding, 'content' ),
			'submitActions' => $enabled,
			'email'         => array(
				'to'       => self::header( $attributes, 'toEmail' ),
				'subject'  => self::header( $attributes, 'subject' ),
				'fromName' => self::header( $attributes, 'fromName' ),
				'replyTo'  => self::header( $attributes, 'replyTo' ),
				'cc'       => self::header( $attributes, 'ccEmail' ),
				'bcc'      => self::header( $attributes, 'bccEmail' ),
			),
			'recaptcha'     => array(
				'enabled' => ! empty( $attributes['enableRecaptcha'] ),
				'version' => 'v3' === self::text( $attributes, 'recaptchaVersion' ) ? 'v3' : 'v2',
			),
			'mailchimp'     => array(
				'apiKeyType'   => self::text( $attributes, 'mailchimpApiKeyType' ),
				'apiKey'       => self::text( $attributes, 'mailchimpApiKey' ),
				'listId'       => self::text( $attributes, 'mailchimpListId' ),
				'mappedFields' => self::mailchimp_mapped_fields( $attributes ),
			),
			'mailerlite'    => array(
				'apiTokenType' => self::text( $attributes, 'mailerliteApiTokenType' ),
				'apiToken'     => self::text( $attributes, 'mailerliteApiToken' ),
				'groupId'      => self::text( $attributes, 'mailerliteGroupId' ),
			),
			'fluentcrm'     => array(
				'lists' => self::id_list( $attributes, 'fluentCRMListIds' ),
				'tags'  => self::id_list( $attributes, 'fluentCRMTags' ),
			),
		);
	}

	/**
	 * The attributes the frontend script may see: everything except API keys and tokens.
	 *
	 * @param array $attributes Block attributes.
	 *
	 * @return array
	 */
	public static function public_attributes( array $attributes ) {
		return array_diff_key( $attributes, array_flip( self::SECRET_ATTRIBUTES ) );
	}

	/**
	 * The success and error messages in the site's language when the block left them at their defaults.
	 *
	 * The editor does not store an attribute that equals its block.json default, so a translated post has
	 * no message attribute for WPML to translate. The default is passed through __() instead, which WPML
	 * String Translation and the plugin's .mo files cover. A message the user typed is kept as saved.
	 * The English strings must stay identical to the defaults in blocks-config/form/block.json.
	 *
	 * @param array $attributes Block attributes, with block.json defaults applied.
	 * @param array $saved      The attributes stored in the block comment ($block->parsed_block['attrs']).
	 *
	 * @return array
	 */
	public static function translate_default_messages( array $attributes, array $saved ) {
		$defaults = array(
			'successMessage' => __( 'Thank you for your message. It has been sent.', 'premium-blocks-for-gutenberg' ),
			'errorMessage'   => __( 'There was an error trying to send your message. Please try again later.', 'premium-blocks-for-gutenberg' ),
		);

		foreach ( $defaults as $name => $message ) {
			if ( ! array_key_exists( $name, $saved ) ) {
				$attributes[ $name ] = $message;
			}
		}

		return $attributes;
	}

	/**
	 * Which form field feeds which Mailchimp merge tag.
	 *
	 * Forms saved before mapped fields existed only have a first name field and a last name field.
	 *
	 * @param array $attributes Block attributes.
	 *
	 * @return array
	 */
	public static function mailchimp_mapped_fields( array $attributes ) {
		$saved = isset( $attributes['mailchimpMappedFields'] ) && is_array( $attributes['mailchimpMappedFields'] ) ? $attributes['mailchimpMappedFields'] : array();

		if ( ! $saved ) {
			$saved = array(
				array(
					'field_name' => '',
					'field_tag'  => 'FNAME',
				),
				array(
					'field_name' => '',
					'field_tag'  => 'LNAME',
				),
			);
		}

		$legacy = array(
			'FNAME' => self::text( $attributes, 'mailchimpFirstNameField' ),
			'LNAME' => self::text( $attributes, 'mailchimpLastNameField' ),
		);
		$mapped = array();

		foreach ( $saved as $field ) {
			if ( ! is_array( $field ) ) {
				continue;
			}

			$name = self::text( $field, 'field_name' );
			$tag  = self::text( $field, 'field_tag' );

			if ( '' === $name && isset( $legacy[ $tag ] ) ) {
				$name = $legacy[ $tag ];
			}

			if ( '' !== $tag ) {
				$mapped[] = array(
					'field_name' => $name,
					'field_tag'  => $tag,
				);
			}
		}

		return $mapped;
	}

	/**
	 * Seal the settings for printing on the page.
	 *
	 * @param array $config Settings from from_attributes().
	 *
	 * @return string Empty when the settings could not be sealed. The handler then refuses the form: there is
	 *                no unsealed fallback.
	 */
	public static function seal( array $config ) {
		if ( ! self::available() ) {
			return '';
		}

		$config['issued'] = time();

		try {
			$nonce = random_bytes( SODIUM_CRYPTO_SECRETBOX_NONCEBYTES );

			return base64_encode( $nonce . sodium_crypto_secretbox( (string) wp_json_encode( $config ), $nonce, self::key() ) ); // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode -- transport encoding of ciphertext.
		} catch ( Exception $e ) {
			return '';
		}
	}

	/**
	 * Whether libsodium's secretbox can be used. WordPress has shipped a PHP implementation since 5.2 for
	 * servers without the extension, so this is false only on a broken install.
	 *
	 * @return bool
	 */
	public static function available() {
		return function_exists( 'sodium_crypto_secretbox' ) && function_exists( 'sodium_crypto_secretbox_open' ) && defined( 'SODIUM_CRYPTO_SECRETBOX_NONCEBYTES' );
	}

	/**
	 * Whether a config was sealed longer ago than a page that printed it can still be in use.
	 *
	 * @param array    $config  An opened config.
	 * @param int      $max_age Seconds.
	 * @param int|null $now     Timestamp, for tests.
	 *
	 * @return bool
	 */
	public static function expired( array $config, $max_age, $now = null ) {
		$now    = null === $now ? time() : (int) $now;
		$issued = isset( $config['issued'] ) ? (int) $config['issued'] : 0;

		// Sixty seconds of tolerance for servers whose clocks differ slightly.
		return $issued <= 0 || $issued > $now + 60 || $now - $issued > (int) $max_age;
	}

	/**
	 * Open settings sent back by the browser.
	 *
	 * @param mixed $sealed The string the page printed.
	 *
	 * @return array|null The settings, or null when this site did not seal them.
	 */
	public static function open( $sealed ) {
		if ( ! is_string( $sealed ) || '' === $sealed || ! self::available() ) {
			return null;
		}

		$raw = base64_decode( $sealed, true ); // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_decode -- transport encoding of ciphertext.

		if ( false === $raw || strlen( $raw ) <= SODIUM_CRYPTO_SECRETBOX_NONCEBYTES + SODIUM_CRYPTO_SECRETBOX_MACBYTES ) {
			return null;
		}

		try {
			$json = sodium_crypto_secretbox_open(
				substr( $raw, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES ),
				substr( $raw, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES ),
				self::key()
			);
		} catch ( Exception $e ) {
			return null;
		}

		if ( false === $json ) {
			return null;
		}

		$config = json_decode( $json, true );

		// A config sealed by this site always has every section, so the handler can read them unchecked.
		return is_array( $config ) && isset( $config['blockId'], $config['draft'], $config['postId'], $config['content'], $config['issued'], $config['submitActions'], $config['email'], $config['recaptcha'], $config['mailchimp'], $config['mailerlite'], $config['fluentcrm'] ) ? $config : null;
	}

	/**
	 * A key for this purpose only, derived from the site's secret salts.
	 *
	 * @return string 32 bytes.
	 */
	private static function key() {
		return hash_hmac( 'sha256', 'pbg_form_config', wp_salt( 'auth' ), true );
	}

	/**
	 * A string attribute, or an empty string.
	 *
	 * @param array  $source Attributes.
	 * @param string $key    Attribute name.
	 *
	 * @return string
	 */
	private static function text( array $source, $key ) {
		return isset( $source[ $key ] ) && is_scalar( $source[ $key ] ) ? trim( (string) $source[ $key ] ) : '';
	}

	/**
	 * A string attribute that ends up in an email header: no line breaks, so it cannot add headers.
	 *
	 * @param array  $source Attributes.
	 * @param string $key    Attribute name.
	 *
	 * @return string
	 */
	private static function header( array $source, $key ) {
		return trim( (string) preg_replace( '/[\r\n]+/', ' ', self::text( $source, $key ) ) );
	}

	/**
	 * A list of scalar ids.
	 *
	 * @param array  $source Attributes.
	 * @param string $key    Attribute name.
	 *
	 * @return array
	 */
	private static function id_list( array $source, $key ) {
		$list = isset( $source[ $key ] ) && is_array( $source[ $key ] ) ? $source[ $key ] : array();

		return array_values( array_filter( $list, 'is_scalar' ) );
	}
}
