<?php
namespace ZFUtils\View\Helper;

// Vendor namespaces
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger as ZendPluginFlashMessenger;
use Zend\Mvc\Plugin\FlashMessenger\View\Helper\FlashMessenger as ZendFlashMessengerViewHelper;

/**
 * BootstrapNotify 
 * Custom implementation of the renderMessages() function of the
 * Zend FlashMessenger View Helper to print growl like notifications
 * using Bootstrap Notify (http://bootstrap-notify.remabledesigns.com/)
 * 
 * @uses   ZendFlashMessengerViewHelper
 * @author Rolando Isidoro (https://github.com/rolandoisidoro) 
 */
class BootstrapNotify extends ZendFlashMessengerViewHelper
{
	/**
	 * View helper config, contains Bootstrap Notify options and settings
	 * @var mixed
	 */
	protected $config = [];

    /**
	 * Renamed default and error namespaces to match BS4 naming convention
     * @var array
     */
    protected $classMessages = [
        'info'    => ZendPluginFlashMessenger::NAMESPACE_INFO,
        'error'   => 'danger',
        'success' => ZendPluginFlashMessenger::NAMESPACE_SUCCESS,
        'default' => 'primary',
        'warning' => ZendPluginFlashMessenger::NAMESPACE_WARNING,
    ];

    /**
     * Templates for the open/close/separators for message tags
     *
     * @var string
     */
    protected $messageOpenFormat = "
		<script>
			$(document).ready( function() {";
	protected $messageSeparatorString = "
				$.notify(
					%s,
					%s
				);";
    protected $messageCloseString = "
			});
		</script>
	";


	/**
	 * __construct 
	 * 
	 * @param  array $config 
	 * @return void
	 */
	public function __construct(array $config)
    {
		$this->config = $config;
    }


    /**
     * Render Messages
     *
     * @param  string    $namespace
     * @param  array     $messages
     * @param  array     $classes
     * @param  bool|null $autoEscape
     * @return string
     */
    protected function renderMessages(
        $namespace      = 'default',
        array $messages = [],
        array $classes  = [],
        $autoEscape     = null
    ) {
		// Return empty string if no messages provided
        if (empty($messages)) {
            return '';
        }

        // Prepare type for separator tag
		if (isset($this->classMessages[$namespace])) {
			$type = $this->classMessages[$namespace];
		} else {
			$type = $this->classMessages['default'];
		}

		// Set auto escape option
        if (null === $autoEscape) {
            $autoEscape = $this->getAutoEscape();
        }

		// Set Bootstrap Notify options and settings
		$options          = $this->config['options'];
		$settings         = $this->config['settings'];
		$settings['type'] = $type;

        // Flatten message array
        $escapeHtml           = $this->getEscapeHtmlHelper();
        $messagesToPrint      = [];
        $translator           = $this->getTranslator();
        $translatorTextDomain = $this->getTranslatorTextDomain();
        array_walk_recursive(
            $messages,
            function ($item) use (& $messagesToPrint, $escapeHtml, $autoEscape, $translator, $translatorTextDomain) {
                if ($translator !== null) {
                    $item = $translator->translate(
                        $item,
                        $translatorTextDomain
                    );
                }

                if ($autoEscape) {
                    $messagesToPrint[] = $escapeHtml($item);
                    return;
                }

                $messagesToPrint[] = $item;
            }
        );

		// Return empty string if no messages to print
        if (empty($messagesToPrint)) {
            return '';
        }

        // Generate markup
        $markup = $this->getMessageOpenFormat();
		
		foreach ($messagesToPrint as $message) {
			$options['message']  = $message;
			$markup             .= sprintf(
				$this->getMessageSeparatorString(),
				json_encode($options), 
				json_encode($settings)
			);
		}

        $markup .= $this->getMessageCloseString();

        return $markup;
    }
}

