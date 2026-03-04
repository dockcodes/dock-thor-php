<?php

declare(strict_types=1);

namespace Dock\Thor;

use Symfony\Component\OptionsResolver\Options as SymfonyOptions;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class Options
{
    public const DEFAULT_MAX_BREADCRUMBS = 100;

    /**
     * @var array
     */
    private $options = [];

    /**
     * @var OptionsResolver
     */
    private $resolver;

    public function __construct(array $options = [])
    {
        $this->resolver = new OptionsResolver();

        $this->configureOptions($this->resolver);

        $this->options = $this->resolver->resolve($options);
    }

    public function getSendAttempts(): int
    {
        return $this->options['send_attempts'];
    }

    public function setSendAttempts(int $attemptsCount): void
    {
        $options = array_merge($this->options, ['send_attempts' => $attemptsCount]);

        $this->options = $this->resolver->resolve($options);
    }

    public function getPrefixes(): array
    {
        return $this->options['prefixes'];
    }

    public function setPrefixes(array $prefixes): void
    {
        $options = array_merge($this->options, ['prefixes' => $prefixes]);

        $this->options = $this->resolver->resolve($options);
    }

    public function getSampleRate(): float
    {
        return $this->options['sample_rate'];
    }

    public function setSampleRate(float $sampleRate): void
    {
        $options = array_merge($this->options, ['sample_rate' => $sampleRate]);

        $this->options = $this->resolver->resolve($options);
    }

    public function getTracesSampleRate(): float
    {
        return $this->options['traces_sample_rate'];
    }

    public function setTracesSampleRate(float $sampleRate): void
    {
        $options = array_merge($this->options, ['traces_sample_rate' => $sampleRate]);

        $this->options = $this->resolver->resolve($options);
    }

    public function isTracingEnabled(): bool
    {
        return 0 != $this->options['traces_sample_rate'] || null !== $this->options['traces_sampler'];
    }

    public function shouldAttachStacktrace(): bool
    {
        return $this->options['attach_stacktrace'];
    }

    public function setAttachStacktrace(bool $enable): void
    {
        $options = array_merge($this->options, ['attach_stacktrace' => $enable]);

        $this->options = $this->resolver->resolve($options);
    }

    public function getContextLines(): ?int
    {
        return $this->options['context_lines'];
    }

    public function setContextLines(?int $contextLines): void
    {
        $options = array_merge($this->options, ['context_lines' => $contextLines]);

        $this->options = $this->resolver->resolve($options);
    }

    public function isCompressionEnabled(): bool
    {
        return $this->options['enable_compression'];
    }

    public function setEnableCompression(bool $enabled): void
    {
        $options = array_merge($this->options, ['enable_compression' => $enabled]);

        $this->options = $this->resolver->resolve($options);
    }

    public function getEnvironment(): ?string
    {
        return $this->options['environment'];
    }

    public function setEnvironment(?string $environment): void
    {
        $options = array_merge($this->options, ['environment' => $environment]);

        $this->options = $this->resolver->resolve($options);
    }

    public function getInAppExcludedPaths(): array
    {
        return $this->options['in_app_exclude'];
    }

    public function setInAppExcludedPaths(array $paths): void
    {
        $options = array_merge($this->options, ['in_app_exclude' => $paths]);

        $this->options = $this->resolver->resolve($options);
    }

    public function getInAppIncludedPaths(): array
    {
        return $this->options['in_app_include'];
    }

    public function setInAppIncludedPaths(array $paths): void
    {
        $options = array_merge($this->options, ['in_app_include' => $paths]);

        $this->options = $this->resolver->resolve($options);
    }

    public function getRelease(): ?string
    {
        return $this->options['release'];
    }

    public function setRelease(?string $release): void
    {
        $options = array_merge($this->options, ['release' => $release]);

        $this->options = $this->resolver->resolve($options);
    }

    public function getAuthData(): ?AuthData
    {
        return $this->options['auth_data'];
    }

    public function getTags(): array
    {
        return $this->options['tags'];
    }

    public function setTags(array $tags): void
    {
        $options = array_merge($this->options, ['tags' => $tags]);

        $this->options = $this->resolver->resolve($options);
    }

    public function getLogger(): string
    {
        return $this->options['logger'];
    }

    public function setLogger(string $logger): void
    {
        $options = array_merge($this->options, ['logger' => $logger]);

        $this->options = $this->resolver->resolve($options);
    }

    public function getServerName(): string
    {
        return $this->options['server_name'];
    }

    public function setServerName(string $serverName): void
    {
        $options = array_merge($this->options, ['server_name' => $serverName]);

        $this->options = $this->resolver->resolve($options);
    }

    public function getBeforeSendCallback(): callable
    {
        return $this->options['before_send'];
    }

    public function setBeforeSendCallback(callable $callback): void
    {
        $options = array_merge($this->options, ['before_send' => $callback]);

        $this->options = $this->resolver->resolve($options);
    }

    public function getErrorTypes(): int
    {
        return $this->options['error_types'] ?? error_reporting();
    }

    public function setErrorTypes(int $errorTypes): void
    {
        $options = array_merge($this->options, ['error_types' => $errorTypes]);

        $this->options = $this->resolver->resolve($options);
    }

    public function getMaxBreadcrumbs(): int
    {
        return $this->options['max_breadcrumbs'];
    }

    public function setMaxBreadcrumbs(int $maxBreadcrumbs): void
    {
        $options = array_merge($this->options, ['max_breadcrumbs' => $maxBreadcrumbs]);

        $this->options = $this->resolver->resolve($options);
    }

    public function getBeforeBreadcrumbCallback(): callable
    {
        return $this->options['before_breadcrumb'];
    }

    public function setBeforeBreadcrumbCallback(callable $callback): void
    {
        $options = array_merge($this->options, ['before_breadcrumb' => $callback]);

        $this->options = $this->resolver->resolve($options);
    }

    public function setIntegrations($integrations): void
    {
        $options = array_merge($this->options, ['integrations' => $integrations]);

        $this->options = $this->resolver->resolve($options);
    }

    public function getIntegrations()
    {
        return $this->options['integrations'];
    }

    public function shouldSendDefaultPii(): bool
    {
        return $this->options['send_default_pii'];
    }

    public function setSendDefaultPii(bool $enable): void
    {
        $options = array_merge($this->options, ['send_default_pii' => $enable]);

        $this->options = $this->resolver->resolve($options);
    }

    public function hasDefaultIntegrations(): bool
    {
        return $this->options['default_integrations'];
    }

    public function setDefaultIntegrations(bool $enable): void
    {
        $options = array_merge($this->options, ['default_integrations' => $enable]);

        $this->options = $this->resolver->resolve($options);
    }

    public function getMaxValueLength(): int
    {
        return $this->options['max_value_length'];
    }

    public function setMaxValueLength(int $maxValueLength): void
    {
        $options = array_merge($this->options, ['max_value_length' => $maxValueLength]);

        $this->options = $this->resolver->resolve($options);
    }

    public function getHttpProxy(): ?string
    {
        return $this->options['http_proxy'];
    }

    public function setHttpProxy(?string $httpProxy): void
    {
        $options = array_merge($this->options, ['http_proxy' => $httpProxy]);

        $this->options = $this->resolver->resolve($options);
    }

    public function shouldCaptureSilencedErrors(): bool
    {
        return $this->options['capture_silenced_errors'];
    }

    public function setCaptureSilencedErrors(bool $shouldCapture): void
    {
        $options = array_merge($this->options, ['capture_silenced_errors' => $shouldCapture]);

        $this->options = $this->resolver->resolve($options);
    }

    public function getMaxRequestBodySize(): string
    {
        return $this->options['max_request_body_size'];
    }

    public function setMaxRequestBodySize(string $maxRequestBodySize): void
    {
        $options = array_merge($this->options, ['max_request_body_size' => $maxRequestBodySize]);

        $this->options = $this->resolver->resolve($options);
    }

    public function getClassSerializers(): array
    {
        return $this->options['class_serializers'];
    }

    public function setClassSerializers(array $serializers): void
    {
        $options = array_merge($this->options, ['class_serializers' => $serializers]);

        $this->options = $this->resolver->resolve($options);
    }

    public function getTracesSampler(): ?callable
    {
        return $this->options['traces_sampler'];
    }

    public function setTracesSampler(?callable $sampler): void
    {
        $options = array_merge($this->options, ['traces_sampler' => $sampler]);

        $this->options = $this->resolver->resolve($options);
    }

    private function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'integrations' => [],
            'default_integrations' => true,
            'send_attempts' => 3,
            'prefixes' => array_filter(explode(\PATH_SEPARATOR, get_include_path() ?: '')),
            'sample_rate' => 1,
            'traces_sample_rate' => 0,
            'traces_sampler' => null,
            'attach_stacktrace' => false,
            'context_lines' => 5,
            'enable_compression' => true,
            'environment' => $_SERVER['THOR_ENVIRONMENT'] ?? null,
            'logger' => 'php',
            'release' => $_SERVER['THOR_RELEASE'] ?? null,
            'token' => $_SERVER['THOR_TOKEN'] ?? null,
            'email' => null,
            'password' => null,
            'private_key' => $_SERVER['THOR_PRIVATE_KEY'] ?? null,
            'auth_data' => [
                'token' => $_SERVER['THOR_TOKEN'] ?? 'enter',
                'private_key' => $_SERVER['THOR_PRIVATE_KEY'] ?? 'enter',
            ],
            'server_name' => gethostname(),
            'before_send' => static function (Event $event): Event {
                return $event;
            },
            'tags' => [],
            'error_types' => null,
            'max_breadcrumbs' => self::DEFAULT_MAX_BREADCRUMBS,
            'before_breadcrumb' => static function (Breadcrumb $breadcrumb): Breadcrumb {
                return $breadcrumb;
            },
            'in_app_exclude' => [],
            'in_app_include' => [],
            'send_default_pii' => false,
            'max_value_length' => 1024,
            'http_proxy' => null,
            'capture_silenced_errors' => false,
            'max_request_body_size' => 'medium',
            'class_serializers' => [],
        ]);

        $resolver->setAllowedTypes('send_attempts', 'int');
        $resolver->setAllowedTypes('prefixes', 'string[]');
        $resolver->setAllowedTypes('sample_rate', ['int', 'float']);
        $resolver->setAllowedTypes('traces_sample_rate', ['int', 'float']);
        $resolver->setAllowedTypes('traces_sampler', ['null', 'callable']);
        $resolver->setAllowedTypes('attach_stacktrace', 'bool');
        $resolver->setAllowedTypes('context_lines', ['null', 'int']);
        $resolver->setAllowedTypes('enable_compression', 'bool');
        $resolver->setAllowedTypes('environment', ['null', 'string']);
        $resolver->setAllowedTypes('in_app_exclude', 'string[]');
        $resolver->setAllowedTypes('in_app_include', 'string[]');
        $resolver->setAllowedTypes('logger', ['null', 'string']);
        $resolver->setAllowedTypes('release', ['null', 'string']);
        $resolver->setAllowedTypes('token', ['null', 'string']);
        $resolver->setAllowedTypes('private_key', ['null', 'string']);
        $resolver->setAllowedTypes('auth_data', ['string[]', AuthData::class]);
        $resolver->setAllowedTypes('server_name', 'string');
        $resolver->setAllowedTypes('before_send', ['callable']);
        $resolver->setAllowedTypes('tags', 'string[]');
        $resolver->setAllowedTypes('error_types', ['null', 'int']);
        $resolver->setAllowedTypes('max_breadcrumbs', 'int');
        $resolver->setAllowedTypes('before_breadcrumb', ['callable']);
        $resolver->setAllowedTypes('integrations', ['Dock\Thor\\Integration\\IntegrationInterface[]', 'callable']);
        $resolver->setAllowedTypes('send_default_pii', 'bool');
        $resolver->setAllowedTypes('default_integrations', 'bool');
        $resolver->setAllowedTypes('max_value_length', 'int');
        $resolver->setAllowedTypes('http_proxy', ['null', 'string']);
        $resolver->setAllowedTypes('capture_silenced_errors', 'bool');
        $resolver->setAllowedTypes('max_request_body_size', 'string');
        $resolver->setAllowedTypes('class_serializers', 'array');

        $resolver->setAllowedValues('max_request_body_size', ['none', 'small', 'medium', 'always']);
        $resolver->setAllowedValues('token', \Closure::fromCallable([$this, 'validateTokenOption']));
        $resolver->setAllowedValues('private_key', \Closure::fromCallable([$this, 'validateTokenOption']));
        $resolver->setAllowedValues('auth_data', \Closure::fromCallable([$this, 'validateAuthDataOption']));
        $resolver->setAllowedValues('max_breadcrumbs', \Closure::fromCallable([$this, 'validateMaxBreadcrumbsOptions']));
        $resolver->setAllowedValues('class_serializers', \Closure::fromCallable([$this, 'validateClassSerializersOption']));
        $resolver->setAllowedValues('context_lines', \Closure::fromCallable([$this, 'validateContextLinesOption']));

        $resolver->setNormalizer('auth_data', \Closure::fromCallable([$this, 'normalizeAuthDataOption']));
        $resolver->setNormalizer('tags', static function (SymfonyOptions $options, array $value): array {
            if (!empty($value)) {
                @trigger_error('The option "tags" is deprecated since version 3.2 and will be removed in 4.0. Either set the tags on the scope or on the event.', \E_USER_DEPRECATED);
            }

            return $value;
        });

        $resolver->setNormalizer('prefixes', function (SymfonyOptions $options, array $value) {
            return array_map([$this, 'normalizeAbsolutePath'], $value);
        });

        $resolver->setNormalizer('in_app_exclude', function (SymfonyOptions $options, array $value) {
            return array_map([$this, 'normalizeAbsolutePath'], $value);
        });

        $resolver->setNormalizer('in_app_include', function (SymfonyOptions $options, array $value) {
            return array_map([$this, 'normalizeAbsolutePath'], $value);
        });

        $resolver->setNormalizer('logger', function (SymfonyOptions $options, ?string $value): ?string {
            if ('php' !== $value) {
                @trigger_error('The option "logger" is deprecated.', \E_USER_DEPRECATED);
            }

            return $value;
        });
    }

    private function normalizeAbsolutePath(string $value): string
    {
        $path = @realpath($value);

        if (false === $path) {
            $path = $value;
        }

        return $path;
    }

    private function normalizeAuthDataOption(SymfonyOptions $options, $value): ?AuthData
    {
        if (null === $value || \is_bool($value) || is_string($value)) {
            return null;
        }

        if ($value instanceof AuthData) {
            return $value;
        }

        if (!is_array($value) || !isset($value['token']) || !isset($value['private_key'])) {
            return null;
        }

        return AuthData::create($value['token'], $value['private_key']);
    }

    private function validateAuthDataOption($data): bool
    {
        if (null === $data || $data instanceof AuthData) {
            return true;
        }
        if (!is_array($data) || !isset($data['token']) || !isset($data['private_key'])) {
            return false;
        }

        try {
            AuthData::create($data['token'], $data['private_key']);

            return true;
        } catch (\InvalidArgumentException $exception) {
            return false;
        }
    }

    private function validateTokenOption($data): bool
    {
        if (null === $data) {
            return true;
        }
        if (\is_bool($data)) {
            return false === $data;
        }

        switch (strtolower($data)) {
            case '':
            case 'false':
            case '(false)':
            case 'empty':
            case '(empty)':
            case 'null':
            case '(null)':
                return true;
        }
        return true;
    }

    private function validateMaxBreadcrumbsOptions(int $value): bool
    {
        return $value >= 0 && $value <= self::DEFAULT_MAX_BREADCRUMBS;
    }

    private function validateClassSerializersOption(array $serializers): bool
    {
        foreach ($serializers as $class => $serializer) {
            if (!\is_string($class) || !\is_callable($serializer)) {
                return false;
            }
        }

        return true;
    }

    private function validateContextLinesOption(?int $contextLines): bool
    {
        return null === $contextLines || $contextLines >= 0;
    }
}
