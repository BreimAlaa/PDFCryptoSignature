<?php
require_once 'Test.php';
require_once '../CryptoManager.php';
class CryptoTest extends Test{
    public function test_generate_public_private_keys(): void
    {
        $keys = CryptoManager::generateKeyPair();
        $this->assertArrayHasKey('private_key', $keys);
        $this->assertArrayHasKey('public_key', $keys);
    }
    public function test_sing_message_with_private_key(): void
    {
        $keys = CryptoManager::generateKeyPair();
        $msg = 'Hello World';
        $signature = CryptoManager::sign($msg, $keys['private_key']);
    }

    public function test_verify_signed_message_message_with_public_key(): void
    {
        $keys = CryptoManager::generateKeyPair();
        $msg = 'Hello World';
        $signature = CryptoManager::sign($msg, $keys['private_key']);
        $this->assertTrue(CryptoManager::verify($msg, $signature, $keys['public_key']));
    }

    public function test_can_not_verify_modified_message_with_public_key(): void
    {
        $keys = CryptoManager::generateKeyPair();
        $msg = 'Hello World';
        $signature = CryptoManager::sign($msg, $keys['private_key']);
        $modified = $msg . '7PI';
        $this->assertFalse(CryptoManager::verify($modified, $signature, $keys['public_key']));
    }

    public function test_encrypt_message_with_private_key(): void
    {
        $keys = CryptoManager::generateKeyPair();
        $msg = 'Hello World';
        CryptoManager::encrypt($msg, $keys['private_key']);
    }

    public function test_decrypt_encrypted_message_with_public_key(): void
    {
        $keys = CryptoManager::generateKeyPair();
        $msg = 'Hello World';
        CryptoManager::encrypt($msg, $keys['private_key']);
    }
}