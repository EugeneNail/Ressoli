<?php

namespace Tests\Unit;

use App\Http\Requests\IndexApplicationsRequest;
use PHPUnit\Framework\TestCase;

class IndexApplicationsValidationTest extends ValidationTestCase {

    public function setUp(): void {
        parent::setUp();
        $this->setRules(IndexApplicationsRequest::class);
    }

    public function test_valid_types_success(): void {
        $this->assertTrue($this->validate(["types", ["houses"]]));
        $this->assertTrue($this->validate(["types", ["apartments"]]));
        $this->assertTrue($this->validate(["types", ["land-parcels"]]));
        $this->assertTrue($this->validate(["types", ["houses", "apartments"]]));
        $this->assertTrue($this->validate(["types", ["houses", "apartments", "land-parcels"]]));
    }

    public function test_invalid_types_failure(): void {
        $this->assertFalse($this->validate(["types", ["test"]]));
        $this->assertFalse($this->validate(["types", ["house"]]));
        $this->assertFalse($this->validate(["types", ["house", "apartments"]]));
    }

    public function test_valid_page_success(): void {
        $this->assertTrue($this->validate(["page", "1"]));
        $this->assertTrue($this->validate(["page", 1]));
        $this->assertTrue($this->validate(["page", "99"]));
    }

    public function test_invalid_page_failure(): void {
        $this->assertFalse($this->validate(["page", null]));
        $this->assertFalse($this->validate(["page", "a"]));
        $this->assertFalse($this->validate(["page", "-1"]));
        $this->assertFalse($this->validate(["page", -1]));
        $this->assertFalse($this->validate(["page", 0]));
        $this->assertFalse($this->validate(["page", "0"]));
    }

    public function test_valid_owned_success(): void {
        $this->assertTrue($this->validate(["owned", null]));
        $this->assertTrue($this->validate(["owned", "true"]));
        $this->assertTrue($this->validate(["owned", "false"]));
    }

    public function test_invalid_owned_failure(): void {
        $this->assertFalse($this->validate(["owned", true]));
        $this->assertFalse($this->validate(["owned", false]));
        $this->assertFalse($this->validate(["owned", "0"]));
        $this->assertFalse($this->validate(["owned", "1"]));
        $this->assertFalse($this->validate(["owned", "2"]));
    }

    public function test_valid_status_success(): void {
        $this->assertTrue($this->validate(["status", null]));
        $this->assertTrue($this->validate(["status", "Active"]));
        $this->assertTrue($this->validate(["status", "Archived"]));
    }

    public function test_invalid_status_failure(): void {
        $this->assertFalse($this->validate(["status", ["active"]]));
        $this->assertFalse($this->validate(["status", ["archive"]]));
    }

    public function test_valid_start_price(): void {
        $this->assertTrue($this->validate(["start-price", 0]));
        $this->assertTrue($this->validate(["start-price", 1]));
        $this->assertTrue($this->validate(["start-price", 10000000]));
        $this->assertTrue($this->validate(["start-price", 1234567]));
    }

    public function test_invalid_start_price(): void {
        $this->assertFalse($this->validate(["start-price", -1]));
        $this->assertFalse($this->validate(["start-price", 0.1]));
        $this->assertFalse($this->validate(["start-price", 10000001]));
    }

    public function test_valid_end_price(): void {
        $this->assertTrue($this->validate(["end-price", 0]));
        $this->assertTrue($this->validate(["end-price", 1]));
        $this->assertTrue($this->validate(["end-price", 10000000]));
        $this->assertTrue($this->validate(["end-price", 1234567]));
    }

    public function test_invalid_end_price(): void {
        $this->assertFalse($this->validate(["end-price", -1]));
        $this->assertFalse($this->validate(["end-price", 0.1]));
        $this->assertFalse($this->validate(["end-price", 10000001]));
    }

    public function test_valid_start_area(): void {
        $this->assertTrue($this->validate(["start-area", 0]));
        $this->assertTrue($this->validate(["start-area", 1]));
        $this->assertTrue($this->validate(["start-area", 10000]));
        $this->assertTrue($this->validate(["start-area", 1234]));
    }

    public function test_invalid_start_area(): void {
        $this->assertFalse($this->validate(["start-area", -1]));
        $this->assertFalse($this->validate(["start-area", 0.1]));
        $this->assertFalse($this->validate(["start-area", 10001]));
    }

    public function test_valid_end_area(): void {
        $this->assertTrue($this->validate(["end-area", 0]));
        $this->assertTrue($this->validate(["end-area", 1]));
        $this->assertTrue($this->validate(["end-area", 10000]));
        $this->assertTrue($this->validate(["end-area", 1234]));
    }

    public function test_invalid_end_area(): void {
        $this->assertFalse($this->validate(["end-area", -1]));
        $this->assertFalse($this->validate(["end-area", 0.1]));
        $this->assertFalse($this->validate(["end-area", 10001]));
    }

    public function test_valid_contract_success(): void {
        $this->assertTrue($this->validate(["contract", null]));
        $this->assertTrue($this->validate(["contract", "Sale"]));
        $this->assertTrue($this->validate(["contract", "Rent"]));
    }

    public function test_invalid_contract_failure(): void {
        $this->assertFalse($this->validate(["contract", ["Sale"]]));
        $this->assertFalse($this->validate(["contract", ["Rent"]]));
    }

    public function test_valid_start_date(): void {
        $this->assertFalse($this->validate(["start-date", "1999-06-15"]));
        $this->assertFalse($this->validate(["start-date", "2024-13-15"]));
        $this->assertFalse($this->validate(["start-date", "2024-06-32"]));
        $this->assertFalse($this->validate(["start-date", "1999-13-32"]));
    }

    public function test_invalid_start_date(): void {
        $this->assertFalse($this->validate(["start-date", "1999-06-15"]));
        $this->assertFalse($this->validate(["start-date", "2024-13-15"]));
        $this->assertFalse($this->validate(["start-date", "2024-06-32"]));
        $this->assertFalse($this->validate(["start-date", "1999-13-32"]));
    }
    public function test_valid_end_date(): void {
        $this->assertFalse($this->validate(["end-date", "1999-06-15"]));
        $this->assertFalse($this->validate(["end-date", "2024-13-15"]));
        $this->assertFalse($this->validate(["end-date", "2024-06-32"]));
        $this->assertFalse($this->validate(["end-date", "1999-13-32"]));
    }

    public function test_invalid_end_date(): void {
        $this->assertFalse($this->validate(["end-date", "1999-06-15"]));
        $this->assertFalse($this->validate(["end-date", "2024-13-15"]));
        $this->assertFalse($this->validate(["end-date", "2024-06-32"]));
        $this->assertFalse($this->validate(["end-date", "1999-13-32"]));
    }

    public function test_valid_no_photos_success(): void {
        $this->assertTrue($this->validate(["no-photos", null]));
        $this->assertTrue($this->validate(["no-photos", "true"]));
        $this->assertTrue($this->validate(["no-photos", "false"]));
    }

    public function test_invalid_no_photos_failure(): void {
        $this->assertFalse($this->validate(["no-photos", true]));
        $this->assertFalse($this->validate(["no-photos", false]));
        $this->assertFalse($this->validate(["no-photos", "0"]));
        $this->assertFalse($this->validate(["no-photos", "1"]));
        $this->assertFalse($this->validate(["no-photos", "2"]));
    }
}
