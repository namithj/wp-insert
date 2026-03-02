<?php
class SmartlogixControls {
	private $type;
	private $plain_html;
	private $use_paragraph;
	private $help_text;
	private $id;
	private $name;
	private $value;
	private $label;
	private $class_name;
	private $style;
	private $required;
	private $options;

	private $option_name;
	private $option_identifier;


	private $pages;
	private $posts;
	private $categories;

	public $values;
	public $html;
	public $js;

	public function __construct( $args = null ) {
		$this->html = '';
		$this->js   = '';

		$this->type          = 'text';
		$this->plain_html    = false;
		$this->use_paragraph = true;
		$this->help_text     = '';
		$this->id            = '';
		$this->name          = '';
		$this->value         = '';
		$this->label         = '';
		$this->class_name    = 'input widefat';
		$this->style         = '';
		$this->required      = '';
		$this->options       = null;

		$this->option_name       = '';
		$this->option_identifier = '';
		$this->values            = '';

		if ( isset( $args ) && is_array( $args ) ) {
			if ( isset( $args['type'] ) && ( '' !== $args['type'] ) ) {
				$this->type = $args['type'];
			}
			if ( isset( $args['plainHTML'] ) && ( '' !== $args['plainHTML'] ) ) {
				$this->plain_html = $args['plainHTML'];
			}
			if ( isset( $args['useParagraph'] ) && ( '' !== $args['useParagraph'] ) ) {
				$this->use_paragraph = $args['useParagraph'];
			}
			if ( isset( $args['helpText'] ) && ( '' !== $args['helpText'] ) ) {
				$this->help_text = $args['helpText'];
			}
			if ( isset( $args['id'] ) && ( '' !== $args['id'] ) ) {
				$this->id = $args['id'];
			}
			if ( isset( $args['name'] ) && ( '' !== $args['name'] ) ) {
				$this->name = $args['name'];
			}
			if ( isset( $args['value'] ) && ( '' !== $args['value'] ) ) {
				$this->value = $args['value'];
			}
			if ( isset( $args['label'] ) && ( '' !== $args['label'] ) ) {
				$this->label = $args['label'];
			}
			if ( isset( $args['className'] ) && ( '' !== $args['className'] ) ) {
				$this->class_name = $args['className'];
			}
			if ( isset( $args['style'] ) && ( '' !== $args['style'] ) ) {
				$this->style = $args['style'];
			}
			if ( isset( $args['required'] ) && ( '' !== $args['required'] ) ) {
				$this->required = $args['required'];
			}
			if ( isset( $args['options'] ) && is_array( $args['options'] ) ) {
				$this->options = $args['options'];
			}

			if ( isset( $args['optionIdentifier'] ) && ( '' !== $args['optionIdentifier'] ) ) {
				$this->option_identifier = $args['optionIdentifier'];
			}
			if ( isset( $args['optionName'] ) && ( '' !== $args['optionName'] ) ) {
				$this->option_name = $args['optionName'];
			}
			if ( isset( $args['values'] ) && ( '' !== $args['values'] ) ) {
				$this->values = $args['values'];
			}

			if ( isset( $args['optionIdentifier'] ) && ( '' !== $args['optionIdentifier'] ) && isset( $args['optionName'] ) && ( '' !== $args['optionName'] ) ) {
				$this->id   = str_replace( [ '[', ']' ], [ '_', '' ], $args['optionIdentifier'] ) . '_' . $args['optionName'];
				$this->name = $args['optionIdentifier'] . '[' . $args['optionName'] . ']';
			} elseif ( isset( $this->option_identifier ) && ( '' !== $this->option_identifier ) && isset( $args['optionName'] ) && ( '' !== $args['optionName'] ) ) {
				$this->id   = str_replace( [ '[', ']' ], [ '_', '' ], $this->option_identifier ) . '_' . $args['optionName'];
				$this->name = $this->option_identifier . '[' . $args['optionName'] . ']';
			} elseif ( isset( $args['optionIdentifier'] ) && ( '' !== $args['optionIdentifier'] ) && isset( $this->option_name ) && ( '' !== $this->option_name ) ) {
				$this->id   = str_replace( [ '[', ']' ], [ '_', '' ], $args['optionIdentifier'] ) . '_' . $this->option_name;
				$this->name = $args['optionIdentifier'] . '[' . $this->option_name . ']';
			} elseif ( isset( $this->option_identifier ) && ( '' !== $this->option_identifier ) && isset( $this->option_name ) && ( '' !== $this->option_name ) ) {
				$this->id   = str_replace( [ '[', ']' ], [ '_', '' ], $this->option_identifier ) . '_' . $this->option_name;
				$this->name = $this->option_identifier . '[' . $this->option_name . ']';
			}

			if ( isset( $args['values'] ) && is_array( $args['values'] ) ) {
				if ( isset( $args['optionName'] ) && ( '' !== $args['optionName'] ) ) {
					$this->value = $args['values'][ $args['optionName'] ];
				} elseif ( isset( $this->option_name ) && ( '' !== $this->option_name ) ) {
					$this->value = $args['values'][ $this->option_name ];
				}
			} elseif ( isset( $this->values ) && is_array( $this->values ) ) {
				if ( isset( $args['optionName'] ) && ( '' !== $args['optionName'] ) ) {
					$this->value = $this->values[ $args['optionName'] ];
				} elseif ( isset( $this->option_name ) && ( '' !== $this->option_name ) ) {
					$this->value = $this->values[ $this->option_name ];
				}
			}
		}
	}

	private function sync_args( $args ) {
		$synced_args = [];
		if ( is_array( $args ) ) {
			$synced_args = $args;
		}

		if ( isset( $args['type'] ) && ( '' !== $args['type'] ) ) {
			$synced_args['type'] = $args['type'];
		} else {
			$synced_args['type'] = $this->type;
		}

		if ( isset( $args['plainHTML'] ) && is_bool( $args['plainHTML'] ) ) {
			$synced_args['plainHTML'] = $args['plainHTML'];
		} else {
			$synced_args['plainHTML'] = $this->plain_html;
		}

		if ( isset( $args['useParagraph'] ) && is_bool( $args['useParagraph'] ) ) {
			$synced_args['useParagraph'] = $args['useParagraph'];
		} else {
			$synced_args['useParagraph'] = $this->use_paragraph;
		}

		if ( isset( $args['helpText'] ) && ( '' !== $args['helpText'] ) ) {
			$synced_args['helpText'] = $args['helpText'];
		} else {
			$synced_args['helpText'] = $this->help_text;
		}

		if ( isset( $args['id'] ) && ( '' !== $args['id'] ) ) {
			$synced_args['id'] = $args['id'];
		} else {
			$synced_args['id'] = $this->id;
		}

		if ( isset( $args['name'] ) && ( '' !== $args['name'] ) ) {
			$synced_args['name'] = $args['name'];
		} else {
			$synced_args['name'] = $this->name;
		}

		if ( isset( $args['label'] ) && ( '' !== $args['label'] ) ) {
			$synced_args['label'] = $args['label'];
		} else {
			$synced_args['label'] = $this->label;
		}

		if ( isset( $args['className'] ) && ( '' !== $args['className'] ) ) {
			$synced_args['className'] = $args['className'];
		} else {
			$synced_args['className'] = $this->class_name;
		}

		if ( isset( $args['style'] ) && ( '' !== $args['style'] ) ) {
			$synced_args['style'] = $args['style'];
		} else {
			$synced_args['style'] = $this->style;
		}

		if ( isset( $args['required'] ) && ( '' !== $args['required'] ) ) {
			$synced_args['required'] = $args['required'];
		} else {
			$synced_args['required'] = $this->required;
		}

		if ( isset( $args['options'] ) && is_array( $args['options'] ) ) {
			$synced_args['options'] = $args['options'];
		} else {
			$synced_args['options'] = $this->options;
		}

		if ( isset( $args['optionIdentifier'] ) && ( '' !== $args['optionIdentifier'] ) && isset( $args['optionName'] ) && ( '' !== $args['optionName'] ) ) {
			$synced_args['id']   = str_replace( [ '[', ']' ], [ '_', '' ], $args['optionIdentifier'] ) . '_' . $args['optionName'];
			$synced_args['name'] = $args['optionIdentifier'] . '[' . $args['optionName'] . ']';
		} elseif ( isset( $this->option_identifier ) && ( '' !== $this->option_identifier ) && isset( $args['optionName'] ) && ( '' !== $args['optionName'] ) ) {
			$synced_args['id']   = str_replace( [ '[', ']' ], [ '_', '' ], $this->option_identifier ) . '_' . $args['optionName'];
			$synced_args['name'] = $this->option_identifier . '[' . $args['optionName'] . ']';
		} elseif ( isset( $args['optionIdentifier'] ) && ( '' !== $args['optionIdentifier'] ) && isset( $this->option_name ) && ( '' !== $this->option_name ) ) {
			$synced_args['id']   = str_replace( [ '[', ']' ], [ '_', '' ], $args['optionIdentifier'] ) . '_' . $this->option_name;
			$synced_args['name'] = $args['optionIdentifier'] . '[' . $this->option_name . ']';
		} elseif ( isset( $this->option_identifier ) && ( '' !== $this->option_identifier ) && isset( $this->option_name ) && ( '' !== $this->option_name ) ) {
			$synced_args['id']   = str_replace( [ '[', ']' ], [ '_', '' ], $this->option_identifier ) . '_' . $this->option_name;
			$synced_args['name'] = $this->option_identifier . '[' . $this->option_name . ']';
		}

		if ( isset( $args['value'] ) && ( '' !== $args['value'] ) ) {
			$synced_args['value'] = $args['value'];
		} elseif ( isset( $args['values'] ) && is_array( $args['values'] ) ) {
			if ( isset( $args['optionName'] ) && ( '' !== $args['optionName'] ) ) {
				$synced_args['value'] = $args['values'][ $args['optionName'] ];
			} elseif ( isset( $this->option_name ) && ( '' !== $this->option_name ) ) {
				$synced_args['value'] = $args['values'][ $this->option_name ];
			}
		} elseif ( isset( $this->values ) && is_array( $this->values ) ) {
			if ( isset( $args['optionName'] ) && ( '' !== $args['optionName'] ) ) {
				$synced_args['value'] = $this->values[ $args['optionName'] ];
			} elseif ( isset( $this->option_name ) && ( '' !== $this->option_name ) ) {
				$synced_args['value'] = $this->values[ $this->option_name ];
			}
		} else {
			$synced_args['value'] = $this->value;
		}

		return $synced_args;
	}

	public function add_control( $args = null ) {
		$control     = $this->get_control( $args, true );
		$this->html .= $control['HTML'];
		$this->js   .= $control['JS'];
	}

	public function get_control( $args = null, $ignore_plain_html = false ) {
		$html = '';
		$js   = '';
		$args = $this->sync_args( $args );

		switch ( $args['type'] ) {
			case 'hidden':
				$html .= '<input type="hidden" ' . ( ( '' !== $args['id'] ) ? 'id="' . $args['id'] . '"' : '' ) . ' ' . ( ( '' !== $args['name'] ) ? 'name="' . $args['name'] . '"' : '' ) . ' ' . ( ( '' !== $args['value'] ) ? 'value="' . esc_attr( sanitize_text_field( $args['value'] ) ) . '"' : '' ) . ' ' . ( ( '' !== $args['className'] ) ? 'class="' . $args['className'] . '"' : '' ) . ' ' . ( ( '' !== $args['style'] ) ? 'style="' . $args['style'] . '"' : '' ) . ' />';
				break;
			case 'text':
				if ( $args['useParagraph'] ) {
					$html .= '<p>'; }
				if ( '' !== $args['label'] ) {
					$html .= '<label ' . ( ( '' !== $args['name'] ) ? 'for="' . $args['name'] . '"' : '' ) . '>' . $args['label'] . '</label><br />'; }
				$html .= '<input type="text" ' . ( ( '' !== $args['id'] ) ? 'id="' . $args['id'] . '"' : '' ) . ' ' . ( ( '' !== $args['name'] ) ? 'name="' . $args['name'] . '"' : '' ) . ' ' . ( ( '' !== $args['value'] ) ? 'value="' . esc_attr( sanitize_text_field( $args['value'] ) ) . '"' : '' ) . ' ' . ( ( '' !== $args['className'] ) ? 'class="' . $args['className'] . '"' : '' ) . ' ' . ( ( '' !== $args['style'] ) ? 'style="' . $args['style'] . '"' : '' ) . ' ' . ( ( $args['required'] ) ? 'required' : '' ) . ' />';
				if ( '' !== $args['helpText'] ) {
					$html .= '<small>' . $args['helpText'] . '</small>'; }
				if ( $args['useParagraph'] ) {
					$html .= '</p>'; }
				break;
			case 'number':
				if ( $args['useParagraph'] ) {
					$html .= '<p>'; }
				if ( '' !== $args['label'] ) {
					$html .= '<label ' . ( ( '' !== $args['name'] ) ? 'for="' . $args['name'] . '"' : '' ) . '>' . $args['label'] . '</label><br />'; }
				$html .= '<input type="number" ' . ( ( '' !== $args['id'] ) ? 'id="' . $args['id'] . '"' : '' ) . ' ' . ( ( '' !== $args['name'] ) ? 'name="' . $args['name'] . '"' : '' ) . ' ' . ( ( '' !== $args['value'] ) ? 'value="' . esc_attr( sanitize_text_field( $args['value'] ) ) . '"' : '' ) . ' ' . ( ( '' !== $args['className'] ) ? 'class="' . $args['className'] . '"' : '' ) . ' ' . ( ( '' !== $args['style'] ) ? 'style="' . $args['style'] . '"' : '' ) . ' ' . ( ( $args['required'] ) ? 'required' : '' ) . ' />';
				if ( '' !== $args['helpText'] ) {
					$html .= '<small>' . $args['helpText'] . '</small>'; }
				if ( $args['useParagraph'] ) {
					$html .= '</p>'; }
				break;
			case 'password':
				if ( $args['useParagraph'] ) {
					$html .= '<p>'; }
				if ( '' !== $args['label'] ) {
					$html .= '<label ' . ( ( '' !== $args['name'] ) ? 'for="' . $args['name'] . '"' : '' ) . '>' . $args['label'] . '</label><br />'; }
				$html .= '<input type="password" ' . ( ( '' !== $args['id'] ) ? 'id="' . $args['id'] . '"' : '' ) . ' ' . ( ( '' !== $args['name'] ) ? 'name="' . $args['name'] . '"' : '' ) . ' ' . ( ( '' !== $args['value'] ) ? 'value="' . esc_attr( sanitize_text_field( $args['value'] ) ) . '"' : '' ) . ' ' . ( ( '' !== $args['className'] ) ? 'class="' . $args['className'] . '"' : '' ) . ' ' . ( ( '' !== $args['style'] ) ? 'style="' . $args['style'] . '"' : '' ) . ' ' . ( ( $args['required'] ) ? 'required' : '' ) . ' />';
				if ( '' !== $args['helpText'] ) {
					$html .= '<small>' . $args['helpText'] . '</small>'; }
				if ( $args['useParagraph'] ) {
					$html .= '</p>'; }
				break;
			case 'textarea':
				if ( $args['useParagraph'] ) {
					$html .= '<p>'; }
				if ( '' !== $args['label'] ) {
					$html .= '<label ' . ( ( '' !== $args['name'] ) ? 'for="' . $args['name'] . '"' : '' ) . '>' . $args['label'] . '</label><br />'; }
				$html .= '<textarea ' . ( ( '' !== $args['id'] ) ? 'id="' . $args['id'] . '"' : '' ) . ' ' . ( ( '' !== $args['name'] ) ? 'name="' . $args['name'] . '"' : '' ) . ' ' . ( ( '' !== $args['className'] ) ? 'class="' . $args['className'] . '"' : '' ) . ' ' . ( ( '' !== $args['style'] ) ? 'style="' . $args['style'] . '"' : '' ) . ' ' . ( ( $args['required'] ) ? 'required' : '' ) . '>' . stripslashes( ( ( '' !== $args['value'] ) ? $args['value'] : '' ) ) . '</textarea>';
				if ( '' !== $args['helpText'] ) {
					$html .= '<small>' . $args['helpText'] . '</small>'; }
				if ( $args['useParagraph'] ) {
					$html .= '</p>'; }
				break;
			case 'checkbox':
				if ( $args['useParagraph'] ) {
					$html .= '<p>'; }
				if ( isset( $args['value'] ) && ( filter_var( $args['value'], FILTER_VALIDATE_BOOLEAN ) ) ) {
					$html .= '<input type="checkbox" ' . ( ( '' !== $args['id'] ) ? 'id="' . $args['id'] . '"' : '' ) . ' ' . ( ( '' !== $args['name'] ) ? 'name="' . $args['name'] . '"' : '' ) . ' value="1" ' . checked( true, true, false ) . ' ' . ( ( '' !== $args['className'] ) ? 'class="' . $args['className'] . '"' : '' ) . ' ' . ( ( '' !== $args['style'] ) ? 'style="' . $args['style'] . '"' : '' ) . ' ' . ( ( $args['required'] ) ? 'required' : '' ) . ' />';
				} else {
					$html .= '<input type="checkbox" ' . ( ( '' !== $args['id'] ) ? 'id="' . $args['id'] . '"' : '' ) . ' ' . ( ( '' !== $args['name'] ) ? 'name="' . $args['name'] . '"' : '' ) . ' value="1" ' . ( ( '' !== $args['className'] ) ? 'class="' . $args['className'] . '"' : '' ) . ' ' . ( ( '' !== $args['style'] ) ? 'style="' . $args['style'] . '"' : '' ) . ' ' . ( ( $args['required'] ) ? 'required' : '' ) . ' />';
				}
				if ( '' !== $args['label'] ) {
					$html .= '&nbsp;<label ' . ( ( '' !== $args['name'] ) ? 'for="' . $args['name'] . '"' : '' ) . '>' . $args['label'] . '</label>'; }
				if ( '' !== $args['helpText'] ) {
					$html .= '<small>' . $args['helpText'] . '</small>'; }
				if ( $args['useParagraph'] ) {
					$html .= '</p>'; }
				break;
			case 'radio':
				if ( $args['useParagraph'] ) {
					$html .= '<p>'; }
				if ( isset( $args['value'] ) && ( filter_var( $args['value'], FILTER_VALIDATE_BOOLEAN ) ) ) {
					$html .= '<input type="radio" ' . ( ( '' !== $args['id'] ) ? 'id="' . $args['id'] . '"' : '' ) . ' ' . ( ( '' !== $args['name'] ) ? 'name="' . $args['name'] . '"' : '' ) . ' value="1" ' . checked( true, true, false ) . ' ' . ( ( '' !== $args['className'] ) ? 'class="' . $args['className'] . '"' : '' ) . ' ' . ( ( '' !== $args['style'] ) ? 'style="' . $args['style'] . '"' : '' ) . ' ' . ( ( $args['required'] ) ? 'required' : '' ) . ' />';
				} else {
					$html .= '<input type="radio" ' . ( ( '' !== $args['id'] ) ? 'id="' . $args['id'] . '"' : '' ) . ' ' . ( ( '' !== $args['name'] ) ? 'name="' . $args['name'] . '"' : '' ) . ' value="1" ' . ( ( '' !== $args['className'] ) ? 'class="' . $args['className'] . '"' : '' ) . ' ' . ( ( '' !== $args['style'] ) ? 'style="' . $args['style'] . '"' : '' ) . ' ' . ( ( $args['required'] ) ? 'required' : '' ) . ' />';
				}
				if ( '' !== $args['label'] ) {
					$html .= '&nbsp;<label ' . ( ( '' !== $args['name'] ) ? 'for="' . $args['name'] . '"' : '' ) . '>' . $args['label'] . '</label>'; }
				if ( '' !== $args['helpText'] ) {
					$html .= '<small>' . $args['helpText'] . '</small>'; }
				if ( $args['useParagraph'] ) {
					$html .= '</p>'; }
				break;
			case 'select':
				if ( $args['useParagraph'] ) {
					$html .= '<p>'; }
				if ( '' !== $args['label'] ) {
					$html .= '<label ' . ( ( '' !== $args['name'] ) ? 'for="' . $args['name'] . '"' : '' ) . '>' . $args['label'] . '</label><br />'; }
				$html .= '<select ' . ( ( '' !== $args['id'] ) ? 'id="' . $args['id'] . '"' : '' ) . ' ' . ( ( '' !== $args['name'] ) ? 'name="' . $args['name'] . '"' : '' ) . ' ' . ( ( '' !== $args['className'] ) ? 'class="' . $args['className'] . '"' : '' ) . ' ' . ( ( '' !== $args['style'] ) ? 'style="' . $args['style'] . '"' : '' ) . ' ' . ( ( $args['required'] ) ? 'required' : '' ) . '>';
				if ( is_array( $args['options'] ) ) {
					foreach ( $args['options'] as $option ) {
						$metadata = '';
						if ( isset( $option['metadata'] ) && is_array( $option['metadata'] ) ) {
							foreach ( $option['metadata'] as $key => $value ) {
								$metadata .= 'data-' . $key . '="' . $value . '"';
							}
						}
						$html .= '<option ' . $metadata . '' . ( ( '' !== $option['value'] ) ? 'value="' . $option['value'] . '"' : '' ) . ' ' . selected( ( ( '' !== $args['value'] ) ? $args['value'] : '' ), ( ( '' !== $option['value'] ) ? $option['value'] : '' ), false ) . '>' . ( ( '' !== $option['text'] ) ? $option['text'] : '' ) . '</option>';
					}
				}
				$html .= '</select>';
				if ( '' !== $args['helpText'] ) {
					$html .= '<small>' . $args['helpText'] . '</small>'; }
				if ( $args['useParagraph'] ) {
					$html .= '</p>'; }
				break;
			case 'choosen-multiselect':
				if ( $args['useParagraph'] ) {
					$html .= '<p>'; }
				if ( '' !== $args['label'] ) {
					$html .= '<label ' . ( ( '' !== $args['name'] ) ? 'for="' . $args['name'] . '"' : '' ) . '>' . $args['label'] . '</label><br />'; }
				$html .= '<select data-placeholder="' . ( ( '' !== $args['label'] ) ? $args['label'] : 'Select Your Options' ) . '" multiple ' . ( ( '' !== $args['id'] ) ? 'id="' . $args['id'] . '"' : '' ) . ' ' . ( ( '' !== $args['name'] ) ? 'name="' . $args['name'] . '"' : '' ) . ' ' . ( ( '' !== $args['value'] ) ? 'value="' . $args['value'] . '"' : '' ) . ' ' . ( ( '' !== $args['className'] ) ? 'class="' . $args['className'] . '"' : '' ) . ' ' . ( ( '' !== $args['style'] ) ? 'style="' . $args['style'] . '"' : '' ) . ' ' . ( ( $args['required'] ) ? 'required' : '' ) . '>';
				if ( is_array( $args['options'] ) ) {
					foreach ( $args['options'] as $option ) {
						if ( in_array( ( ( '' !== $option['value'] ) ? $option['value'] : '' ), ( ( is_array( $args['value'] ) ) ? $args['value'] : [] ), true ) ) {
							$html .= '<option ' . ( ( '' !== $option['value'] ) ? 'value="' . $option['value'] . '"' : '' ) . ' ' . selected( 1, 1, false ) . '>' . ( ( '' !== $option['text'] ) ? $option['text'] : '' ) . '</option>';
						} else {
							$html .= '<option ' . ( ( '' !== $option['value'] ) ? 'value="' . $option['value'] . '"' : '' ) . '>' . ( ( '' !== $option['text'] ) ? $option['text'] : '' ) . '</option>';
						}
					}
				}
				$html .= '</select>';
				if ( '' !== $args['helpText'] ) {
					$html .= '<small>' . $args['helpText'] . '</small>'; }
				if ( $args['useParagraph'] ) {
					$html .= '</p>'; }
				$js .= 'jQuery("#' . ( ( '' !== $args['id'] ) ? $args['id'] : '' ) . '").chosen({ width: "100%" }).on("change", function(evt, params) { jQuery("#' . ( ( '' !== $args['id'] ) ? $args['id'] : '' ) . '_chosen .search-field input").click(); }).trigger("chosen:open");';
				break;
			case 'radio-group':
				if ( $args['useParagraph'] ) {
					$html .= '<p>'; }
				if ( '' !== $args['label'] ) {
					$html .= '<label ' . ( ( '' !== $args['name'] ) ? 'for="' . $args['name'] . '"' : '' ) . '>' . $args['label'] . '</label><br />'; }
				if ( is_array( $args['options'] ) ) {
					$index = 1;
					foreach ( $args['options'] as $option ) {
						$html .= '<input type="radio" ' . ( ( '' !== $args['id'] ) ? 'id="' . $args['id'] . '_' . $index . '"' : '' ) . ' ' . ( ( '' !== $args['name'] ) ? 'name="' . $args['name'] . '"' : '' ) . ' ' . ( ( '' !== $option['value'] ) ? 'value="' . $option['value'] . '"' : '' ) . ' ' . checked( ( ( isset( $args['value'] ) ) ? $args['value'] : '' ), ( ( isset( $option['value'] ) ) ? $option['value'] : '' ), false ) . ' ' . ( ( '' !== $args['className'] ) ? 'class="' . $args['className'] . '"' : '' ) . ' ' . ( ( '' !== $args['style'] ) ? 'style="' . $args['style'] . '"' : '' ) . ' />';
						if ( '' !== $option['text'] ) {
							$html .= '&nbsp;<label ' . ( ( '' !== $args['name'] ) ? 'for="' . $args['name'] . '"' : '' ) . ' ' . ( ( '' !== $args['style'] ) ? 'style="' . $args['style'] . '"' : '' ) . '>' . ( ( '' !== $option['text'] ) ? $option['text'] : '' ) . '</label><br />'; }
						++$index;
					}
				}
				if ( '' !== $args['helpText'] ) {
					$html .= '<small>' . $args['helpText'] . '</small>'; }
				if ( $args['useParagraph'] ) {
					$html .= '</p>'; }
				break;
			case 'ipCheckbox':
				if ( $args['useParagraph'] ) {
					$html .= '<p>'; }
				if ( isset( $args['value'] ) && ( filter_var( $args['value'], FILTER_VALIDATE_BOOLEAN ) ) ) {
					$html .= '<input type="checkbox" ' . ( ( '' !== $args['id'] ) ? 'id="' . $args['id'] . '"' : '' ) . ' ' . ( ( '' !== $args['name'] ) ? 'name="' . $args['name'] . '"' : '' ) . ' value="true" ' . checked( true, true, false ) . ' ' . ( ( '' !== $args['className'] ) ? 'class="ipCheckbox ' . $args['className'] . '"' : 'class="ipCheckbox"' ) . ' ' . ( ( '' !== $args['style'] ) ? 'style="' . $args['style'] . '"' : '' ) . ' ' . ( ( $args['required'] ) ? 'required' : '' ) . ' />';
				} else {
					$html .= '<input type="checkbox" ' . ( ( '' !== $args['id'] ) ? 'id="' . $args['id'] . '"' : '' ) . ' ' . ( ( '' !== $args['name'] ) ? 'name="' . $args['name'] . '"' : '' ) . ' value="true" ' . ( ( '' !== $args['className'] ) ? 'class="ipCheckbox ' . $args['className'] . '"' : 'class="ipCheckbox"' ) . ' ' . ( ( '' !== $args['style'] ) ? 'style="' . $args['style'] . '"' : '' ) . ' ' . ( ( $args['required'] ) ? 'required' : '' ) . ' />';
				}
				if ( '' !== $args['label'] ) {
					$html .= '&nbsp;<label ' . ( ( '' !== $args['name'] ) ? 'for="' . $args['name'] . '"' : '' ) . '>' . $args['label'] . '</label>'; }
				if ( '' !== $args['helpText'] ) {
					$html .= '<small>' . $args['helpText'] . '</small>'; }
				if ( $args['useParagraph'] ) {
					$html .= '</p>'; }
				$js .= 'jQuery("#' . ( ( '' !== $args['id'] ) ? $args['id'] : '' ) . '").ipCheckbox();';
				break;
			case 'minicolors':
				if ( $args['useParagraph'] ) {
					$html .= '<p>'; }
				if ( '' !== $args['label'] ) {
					$html .= '<label ' . ( ( '' !== $args['name'] ) ? 'for="' . $args['name'] . '"' : '' ) . '>' . $args['label'] . '</label><br />'; }
				$html .= '<input type="text" ' . ( ( '' !== $args['id'] ) ? 'id="' . $args['id'] . '"' : '' ) . ' ' . ( ( '' !== $args['name'] ) ? 'name="' . $args['name'] . '"' : '' ) . ' ' . ( ( '' !== $args['value'] ) ? 'value="' . $args['value'] . '"' : '' ) . ' ' . ( ( '' !== $args['className'] ) ? 'class="' . $args['className'] . '"' : '' ) . ' ' . ( ( '' !== $args['style'] ) ? 'style="' . $args['style'] . '"' : '' ) . ' ' . ( ( $args['required'] ) ? 'required' : '' ) . ' />';
				if ( '' !== $args['helpText'] ) {
					$html .= '<small>' . $args['helpText'] . '</small>'; }
				if ( $args['useParagraph'] ) {
					$html .= '</p>'; }
				$js .= 'jQuery("#' . ( ( '' !== $args['id'] ) ? $args['id'] : '' ) . '").minicolors();';
				break;
			case 'textarea-wysiwyg':
				if ( $args['useParagraph'] ) {
					$html .= '<p>'; }
				if ( '' !== $args['label'] ) {
					$html .= '<label ' . ( ( '' !== $args['name'] ) ? 'for="' . $args['name'] . '"' : '' ) . '>' . $args['label'] . '</label><br />'; }
				$html .= '<textarea ' . ( ( '' !== $args['id'] ) ? 'id="' . $args['id'] . '"' : '' ) . ' ' . ( ( '' !== $args['name'] ) ? 'name="' . $args['name'] . '"' : '' ) . ' ' . ( ( '' !== $args['className'] ) ? 'class="' . $args['className'] . '"' : '' ) . ' ' . ( ( '' !== $args['style'] ) ? 'style="' . $args['style'] . '"' : '' ) . ' ' . ( ( $args['required'] ) ? 'required' : '' ) . '>' . stripslashes( ( ( '' !== $args['value'] ) ? $args['value'] : '' ) ) . '</textarea>';
				if ( '' !== $args['helpText'] ) {
					$html .= '<small>' . $args['helpText'] . '</small>'; }
				if ( $args['useParagraph'] ) {
					$html .= '</p>'; }
				$js .= 'jQuery("#' . ( ( '' !== $args['id'] ) ? $args['id'] : '' ) . '").jqte();';
				break;
			case 'checkbox-button':
				if ( $args['useParagraph'] ) {
					$html .= '<p>'; }
				if ( isset( $args['value'] ) && ( filter_var( $args['value'], FILTER_VALIDATE_BOOLEAN ) ) ) {
					$html .= '<input type="checkbox" ' . ( ( '' !== $args['id'] ) ? 'id="' . $args['id'] . '"' : '' ) . ' ' . ( ( '' !== $args['name'] ) ? 'name="' . $args['name'] . '"' : '' ) . ' value="true" ' . checked( true, true, false ) . ' ' . ( ( '' !== $args['className'] ) ? 'class="' . $args['className'] . '"' : '' ) . ' ' . ( ( '' !== $args['style'] ) ? 'style="' . $args['style'] . '"' : '' ) . ' ' . ( ( $args['required'] ) ? 'required' : '' ) . ' />';
				} else {
					$html .= '<input type="checkbox" ' . ( ( '' !== $args['id'] ) ? 'id="' . $args['id'] . '"' : '' ) . ' ' . ( ( '' !== $args['name'] ) ? 'name="' . $args['name'] . '"' : '' ) . ' value="true" ' . ( ( '' !== $args['className'] ) ? 'class="' . $args['className'] . '"' : '' ) . ' ' . ( ( '' !== $args['style'] ) ? 'style="' . $args['style'] . '"' : '' ) . ' ' . ( ( $args['required'] ) ? 'required' : '' ) . ' />';
				}
				if ( '' !== $args['label'] ) {
					$html .= '<label for="' . ( ( '' !== $args['id'] ) ? $args['id'] : '' ) . '">' . $args['label'] . '</label>'; }
				if ( '' !== $args['helpText'] ) {
					$html .= '<small>' . $args['helpText'] . '</small>'; }
				if ( $args['useParagraph'] ) {
					$html .= '</p>'; }
				$js .= 'jQuery("#' . ( ( '' !== $args['id'] ) ? $args['id'] : '' ) . '").button({ create:  function(event, ui) { jQuery(this).button("option", "label", (jQuery(this).is(":checked")?"' . ( ( '' !== $args['checkedLabel'] ) ? $args['checkedLabel'] : '' ) . '":"' . ( ( '' !== $args['uncheckedLabel'] ) ? $args['uncheckedLabel'] : '' ) . '")) }}).change(function () { jQuery(this).button("option", "label", (jQuery(this).is(":checked")?"' . ( ( '' !== $args['checkedLabel'] ) ? $args['checkedLabel'] : '' ) . '":"' . ( ( '' !== $args['uncheckedLabel'] ) ? $args['uncheckedLabel'] : '' ) . '")); });';
				break;
			case 'pages-select':
				$this->load_data( 'pages' );
				if ( $args['useParagraph'] ) {
					$html .= '<p>'; }
				if ( '' !== $args['label'] ) {
					$html .= '<label ' . ( ( '' !== $args['name'] ) ? 'for="' . $args['name'] . '"' : '' ) . '>' . $args['label'] . '</label><br />'; }
				$html .= '<select ' . ( ( '' !== $args['id'] ) ? 'id="' . $args['id'] . '"' : '' ) . ' ' . ( ( '' !== $args['name'] ) ? 'name="' . $args['name'] . '"' : '' ) . ' ' . ( ( '' !== $args['value'] ) ? 'value="' . $args['value'] . '"' : '' ) . ' ' . ( ( '' !== $args['className'] ) ? 'class="' . $args['className'] . '"' : '' ) . ' ' . ( ( '' !== $args['style'] ) ? 'style="' . $args['style'] . '"' : '' ) . ' ' . ( ( $args['required'] ) ? 'required' : '' ) . '>';
				if ( is_array( $this->pages ) ) {
					foreach ( $this->pages as $option ) {
						$html .= '<option ' . ( ( '' !== $option['value'] ) ? 'value="' . $option['value'] . '"' : '' ) . ' ' . selected( ( ( '' !== $args['value'] ) ? $args['value'] : '' ), ( ( '' !== $option['value'] ) ? $option['value'] : '' ), false ) . '>' . ( ( '' !== $option['text'] ) ? $option['text'] : '' ) . '</option>';
					}
				}
				$html .= '</select>';
				if ( '' !== $args['helpText'] ) {
					$html .= '<small>' . $args['helpText'] . '</small>'; }
				if ( $args['useParagraph'] ) {
					$html .= '</p>'; }
				break;
			case 'pages-chosen-multiselect':
				$this->load_data( 'pages' );
				if ( $args['useParagraph'] ) {
					$html .= '<p>'; }
				if ( '' !== $args['label'] ) {
					$html .= '<label ' . ( ( '' !== $args['name'] ) ? 'for="' . $args['name'] . '"' : '' ) . '>' . $args['label'] . '</label><br />'; }
				$html .= '<select multiple data-placeholder="' . ( ( '' !== $args['label'] ) ? $args['label'] : 'Select Your Options' ) . '" ' . ( ( '' !== $args['id'] ) ? 'id="' . $args['id'] . '"' : '' ) . ' ' . ( ( '' !== $args['name'] ) ? 'name="' . $args['name'] . '"' : '' ) . ' ' . ( ( '' !== $args['value'] ) ? 'value="' . $args['value'] . '"' : '' ) . ' ' . ( ( '' !== $args['className'] ) ? 'class="' . $args['className'] . '"' : '' ) . ' ' . ( ( '' !== $args['style'] ) ? 'style="' . $args['style'] . '"' : '' ) . ' ' . ( ( $args['required'] ) ? 'required' : '' ) . '>';
				if ( is_array( $this->pages ) ) {
					foreach ( $this->pages as $option ) {
						if ( in_array( ( ( '' !== $option['value'] ) ? $option['value'] : '' ), ( ( is_array( $args['value'] ) ) ? $args['value'] : [] ), true ) ) {
							$html .= '<option ' . ( ( '' !== $option['value'] ) ? 'value="' . $option['value'] . '"' : '' ) . ' ' . selected( 1, 1, false ) . '>' . ( ( '' !== $option['text'] ) ? $option['text'] : '' ) . '</option>';
						} else {
							$html .= '<option ' . ( ( '' !== $option['value'] ) ? 'value="' . $option['value'] . '"' : '' ) . '>' . ( ( '' !== $option['text'] ) ? $option['text'] : '' ) . '</option>';
						}
					}
				}
				$html .= '</select>';
				if ( '' !== $args['helpText'] ) {
					$html .= '<small>' . $args['helpText'] . '</small>'; }
				if ( $args['useParagraph'] ) {
					$html .= '</p>'; }
				$js .= 'jQuery("#' . ( ( '' !== $args['id'] ) ? $args['id'] : '' ) . '").chosen({ width: "100%" }).on("change", function(evt, params) { jQuery("#' . ( ( '' !== $args['id'] ) ? $args['id'] : '' ) . '_chosen .search-field input").click(); }).trigger("chosen:open");';
				break;
			case 'posts-select':
				$this->load_data( 'posts' );
				if ( $args['useParagraph'] ) {
					$html .= '<p>'; }
				if ( '' !== $args['label'] ) {
					$html .= '<label ' . ( ( '' !== $args['name'] ) ? 'for="' . $args['name'] . '"' : '' ) . '>' . $args['label'] . '</label><br />'; }
				$html .= '<select ' . ( ( '' !== $args['id'] ) ? 'id="' . $args['id'] . '"' : '' ) . ' ' . ( ( '' !== $args['name'] ) ? 'name="' . $args['name'] . '"' : '' ) . ' ' . ( ( '' !== $args['value'] ) ? 'value="' . $args['value'] . '"' : '' ) . ' ' . ( ( '' !== $args['className'] ) ? 'class="' . $args['className'] . '"' : '' ) . ' ' . ( ( '' !== $args['style'] ) ? 'style="' . $args['style'] . '"' : '' ) . ' ' . ( ( $args['required'] ) ? 'required' : '' ) . '>';
				if ( is_array( $this->posts ) ) {
					foreach ( $this->posts as $option ) {
						$html .= '<option ' . ( ( '' !== $option['value'] ) ? 'value="' . $option['value'] . '"' : '' ) . ' ' . selected( ( ( '' !== $args['value'] ) ? $args['value'] : '' ), ( ( '' !== $option['value'] ) ? $option['value'] : '' ), false ) . '>' . ( ( '' !== $option['text'] ) ? $option['text'] : '' ) . '</option>';
					}
				}
				$html .= '</select>';
				if ( '' !== $args['helpText'] ) {
					$html .= '<small>' . $args['helpText'] . '</small>'; }
				if ( $args['useParagraph'] ) {
					$html .= '</p>'; }
				break;
			case 'posts-chosen-multiselect':
				$this->load_data( 'posts' );
				if ( $args['useParagraph'] ) {
					$html .= '<p>'; }
				if ( '' !== $args['label'] ) {
					$html .= '<label ' . ( ( '' !== $args['name'] ) ? 'for="' . $args['name'] . '"' : '' ) . '>' . $args['label'] . '</label><br />'; }
				$html .= '<select multiple data-placeholder="' . ( ( '' !== $args['label'] ) ? $args['label'] : 'Select Your Options' ) . '" ' . ( ( '' !== $args['id'] ) ? 'id="' . $args['id'] . '"' : '' ) . ' ' . ( ( '' !== $args['name'] ) ? 'name="' . $args['name'] . '"' : '' ) . ' ' . ( ( '' !== $args['value'] ) ? 'value="' . $args['value'] . '"' : '' ) . ' ' . ( ( '' !== $args['className'] ) ? 'class="' . $args['className'] . '"' : '' ) . ' ' . ( ( '' !== $args['style'] ) ? 'style="' . $args['style'] . '"' : '' ) . ' ' . ( ( $args['required'] ) ? 'required' : '' ) . '>';
				if ( is_array( $this->posts ) ) {
					foreach ( $this->posts as $option ) {
						if ( in_array( ( ( '' !== $option['value'] ) ? $option['value'] : '' ), ( ( is_array( $args['value'] ) ) ? $args['value'] : [] ), true ) ) {
							$html .= '<option ' . ( ( '' !== $option['value'] ) ? 'value="' . $option['value'] . '"' : '' ) . ' ' . selected( 1, 1, false ) . '>' . ( ( '' !== $option['text'] ) ? $option['text'] : '' ) . '</option>';
						} else {
							$html .= '<option ' . ( ( '' !== $option['value'] ) ? 'value="' . $option['value'] . '"' : '' ) . '>' . ( ( '' !== $option['text'] ) ? $option['text'] : '' ) . '</option>';
						}
					}
				}
				$html .= '</select>';
				if ( '' !== $args['helpText'] ) {
					$html .= '<small>' . $args['helpText'] . '</small>'; }
				if ( $args['useParagraph'] ) {
					$html .= '</p>'; }
				$js .= 'jQuery("#' . ( ( '' !== $args['id'] ) ? $args['id'] : '' ) . '").chosen({ width: "100%" }).on("change", function(evt, params) { jQuery("#' . ( ( '' !== $args['id'] ) ? $args['id'] : '' ) . '_chosen .search-field input").click(); }).trigger("chosen:open");';
				break;
			case 'categories-select':
				$this->load_data( 'categories' );
				if ( $args['useParagraph'] ) {
					$html .= '<p>'; }
				if ( '' !== $args['label'] ) {
					$html .= '<label ' . ( ( '' !== $args['name'] ) ? 'for="' . $args['name'] . '"' : '' ) . '>' . $args['label'] . '</label><br />'; }
				$html .= '<select ' . ( ( '' !== $args['id'] ) ? 'id="' . $args['id'] . '"' : '' ) . ' ' . ( ( '' !== $args['name'] ) ? 'name="' . $args['name'] . '"' : '' ) . ' ' . ( ( '' !== $args['value'] ) ? 'value="' . $args['value'] . '"' : '' ) . ' ' . ( ( '' !== $args['className'] ) ? 'class="' . $args['className'] . '"' : '' ) . ' ' . ( ( '' !== $args['style'] ) ? 'style="' . $args['style'] . '"' : '' ) . ' ' . ( ( $args['required'] ) ? 'required' : '' ) . '>';
				if ( is_array( $this->categories ) ) {
					foreach ( $this->categories as $option ) {
						$html .= '<option ' . ( ( '' !== $option['value'] ) ? 'value="' . $option['value'] . '"' : '' ) . ' ' . selected( ( ( '' !== $args['value'] ) ? $args['value'] : '' ), ( ( '' !== $option['value'] ) ? $option['value'] : '' ), false ) . '>' . ( ( '' !== $option['text'] ) ? $option['text'] : '' ) . '</option>';
					}
				}
				$html .= '</select>';
				if ( '' !== $args['helpText'] ) {
					$html .= '<small>' . $args['helpText'] . '</small>'; }
				if ( $args['useParagraph'] ) {
					$html .= '</p>'; }
				break;
			case 'categories-chosen-multiselect':
				$this->load_data( 'categories' );
				if ( $args['useParagraph'] ) {
					$html .= '<p>'; }
				if ( '' !== $args['label'] ) {
					$html .= '<label ' . ( ( '' !== $args['name'] ) ? 'for="' . $args['name'] . '"' : '' ) . '>' . $args['label'] . '</label><br />'; }
				$html .= '<select multiple data-placeholder="' . ( ( '' !== $args['label'] ) ? $args['label'] : 'Select Your Options' ) . '" ' . ( ( '' !== $args['id'] ) ? 'id="' . $args['id'] . '"' : '' ) . ' ' . ( ( '' !== $args['name'] ) ? 'name="' . $args['name'] . '"' : '' ) . ' ' . ( ( '' !== $args['value'] ) ? 'value="' . $args['value'] . '"' : '' ) . ' ' . ( ( '' !== $args['className'] ) ? 'class="' . $args['className'] . '"' : '' ) . ' ' . ( ( '' !== $args['style'] ) ? 'style="' . $args['style'] . '"' : '' ) . ' ' . ( ( $args['required'] ) ? 'required' : '' ) . '>';
				if ( is_array( $this->categories ) ) {
					foreach ( $this->categories as $option ) {
						if ( in_array( ( ( '' !== $option['value'] ) ? $option['value'] : '' ), ( ( is_array( $args['value'] ) ) ? $args['value'] : [] ), true ) ) {
							$html .= '<option ' . ( ( '' !== $option['value'] ) ? 'value="' . $option['value'] . '"' : '' ) . ' ' . selected( 1, 1, false ) . '>' . ( ( '' !== $option['text'] ) ? $option['text'] : '' ) . '</option>';
						} else {
							$html .= '<option ' . ( ( '' !== $option['value'] ) ? 'value="' . $option['value'] . '"' : '' ) . '>' . ( ( '' !== $option['text'] ) ? $option['text'] : '' ) . '</option>';
						}
					}
				}
				$html .= '</select>';
				if ( '' !== $args['helpText'] ) {
					$html .= '<small>' . $args['helpText'] . '</small>'; }
				if ( $args['useParagraph'] ) {
					$html .= '</p>'; }
				$js .= 'jQuery("#' . ( ( '' !== $args['id'] ) ? $args['id'] : '' ) . '").chosen({ width: "100%" }).on("change", function(evt, params) { jQuery("#' . ( ( '' !== $args['id'] ) ? $args['id'] : '' ) . '_chosen .search-field input").click(); }).trigger("chosen:open");';
				break;
		}

		if ( $args['plainHTML'] && ! $ignore_plain_html ) {
			return $html;
		} else {
			return [
				'HTML' => $html,
				'JS'   => $js,
			];
		}
	}

	private function load_data( $type ) {
		switch ( $type ) {
			case 'pages':
				if ( ! is_array( $this->pages ) ) {
					$pages = get_pages( 'numberposts=100' );
					if ( isset( $pages ) && is_array( $pages ) ) {
						$this->pages = [];
						foreach ( $pages as $page ) {
							$this->pages[] = [
								'text'  => ( ( '' !== $page->post_title ) ? $page->post_title : 'Untitled Page (' . $page->ID . ')' ),
								'value' => $page->ID,
							];
						}
					}
				}
				break;
			case 'posts':
				if ( ! is_array( $this->posts ) ) {
					$posts = get_posts( 'numberposts=100' );
					if ( isset( $posts ) && is_array( $posts ) ) {
						$this->posts = [];
						foreach ( $posts as $post ) {
							$this->posts[] = [
								'text'  => $post->post_title,
								'value' => $post->ID,
							];
						}
					}
				}
				break;
			case 'categories':
				if ( ! is_array( $this->categories ) ) {
					$categories = get_categories( 'number=200&hide_empty=0' );
					if ( isset( $categories ) && is_array( $categories ) ) {
						$this->categories = [];
						foreach ( $categories as $category ) {
							$this->categories[] = [
								'text'  => $category->name,
								'value' => $category->term_id,
							];
						}
					}
				}
				break;
		}
	}

	public function create_section( $section_title = '', $include_block = true ) {
		$wrapper_html = '<div class="smartlogixControlsSectionWrapper">';
		if ( '' !== $section_title ) {
			$wrapper_html .= '<label class="smartlogixControlsSectionTitle">' . $section_title . '</label>';
		}
		if ( $include_block ) {
			$wrapper_html .= $this->create_block();
		}
			$wrapper_html .= $this->html;
		$wrapper_html     .= '</div>';
		$this->html        = $wrapper_html;
	}

	public function create_block() {
		$this->html = '<div class="smartlogixControlsSectionInner">' . $this->html . '</div>';
	}

	public function set_html( $html ) {
		$this->html = $html;
	}

	public function clear_controls( $clear_html = true, $clear_js = false ) {
		if ( $clear_html ) {
			$this->html = '';
		}
		if ( $clear_js ) {
			$this->js = '';
		}
	}

	public static function enqueue_assets( $path, $version = '1' ) {
		wp_register_style( 'smartlogix-controls-css', $path . '/css/controls.css', [], $version );
		wp_enqueue_style( 'smartlogix-controls-css' );
		wp_register_script( 'smartlogix-controls-js', $path . '/js/controls.js', [ 'jquery', 'jquery-ui-core' ], $version, true );
		wp_enqueue_script( 'smartlogix-controls-js' );
	}
}
