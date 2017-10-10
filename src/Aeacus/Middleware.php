<?php

namespace Aeacus;

class Middleware extends \Phalcon\Mvc\User\Plugin {

  private $headerKey = 'Authorization';
  private $prefixToken = 'Bearer ';
  private $encryptAlgorism = 'RS256';

  public function getHeaderKey(): string {
    return $this->headerKey;
  }

  public function setHeaderKey(string $value): void {
    $this->headerKey = $value;
  }

  public function getPrefixToken(): string {
    return $this->prefixToken;
  }

  public function setPrefixToken(string $value): void {
    $this->prefixToken = $value;
  }

  public function getEncryptAlgorism(): string {
    return $this->encryptAlgorism;
  }

  public function setEncryptAlgorism(string $value): void {
    $this->encryptAlgorism = $value;
  }

  public function check(\Phalcon\Events\Event $event, \Phalcon\Di\Injectable $injectable, array $publicKeys): void {
    $di = $injectable->getDi();

    $authorization = $di->getRequest()->getHeader('Authorization');
    preg_match("/^{$this->prefixToken}(\S+)$/", $authorization, $matches);

    $token = $matches[1] ?? null;
    if (!$token) {
      throw new Exception('can not find authorization token', ExceptionCodes::notFoundToken);
    }

    try {
      $decoded = \Firebase\JWT\JWT::decode($token, $publicKeys, [$this->encryptAlgorism]);
      $decoded->token = $token;
      $di->setShared(ServiceKeys::decodedToken, $decoded);
    } catch (\Exception $error) {
      throw new Exception('invalid token', ExceptionCodes::invalidToken);
    }
  }
}
