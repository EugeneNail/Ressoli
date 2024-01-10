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

    public function test_valid_statuses_success(): void {
        $this->assertTrue($this->validate(["statuses", null]));
        $this->assertTrue($this->validate(["statuses", ["active"]]));
        $this->assertTrue($this->validate(["statuses", ["archived"]]));
        $this->assertTrue($this->validate(["statuses", ["active", "archived"]]));
    }

    public function test_invalid_statuses_failure(): void {
        $this->assertFalse($this->validate(["statuses", "active"]));
        $this->assertFalse($this->validate(["statuses", ["archive"]]));
    }

    public function test_valid_min_price(): void {
        $this->assertTrue($this->validate(["min-price", 0]));
        $this->assertTrue($this->validate(["min-price", 1]));
        $this->assertTrue($this->validate(["min-price", 10000000]));
        $this->assertTrue($this->validate(["min-price", 1234567]));
    }

    public function test_invalid_min_price(): void {
        $this->assertFalse($this->validate(["min-price", -1]));
        $this->assertFalse($this->validate(["min-price", 0.1]));
        $this->assertFalse($this->validate(["min-price", 10000001]));
    }

    public function test_valid_max_price(): void {
        $this->assertTrue($this->validate(["max-price", 0]));
        $this->assertTrue($this->validate(["max-price", 1]));
        $this->assertTrue($this->validate(["max-price", 10000000]));
        $this->assertTrue($this->validate(["max-price", 1234567]));
    }

    public function test_invalid_max_price(): void {
        $this->assertFalse($this->validate(["max-price", -1]));
        $this->assertFalse($this->validate(["max-price", 0.1]));
        $this->assertFalse($this->validate(["max-price", 10000001]));
    }

    public function test_valid_min_area(): void {
        $this->assertTrue($this->validate(["min-area", 0]));
        $this->assertTrue($this->validate(["min-area", 1]));
        $this->assertTrue($this->validate(["min-area", 10000]));
        $this->assertTrue($this->validate(["min-area", 1234]));
    }

    public function test_invalid_min_area(): void {
        $this->assertFalse($this->validate(["min-area", -1]));
        $this->assertFalse($this->validate(["min-area", 0.1]));
        $this->assertFalse($this->validate(["min-area", 10001]));
    }

    public function test_valid_max_area(): void {
        $this->assertTrue($this->validate(["max-area", 0]));
        $this->assertTrue($this->validate(["max-area", 1]));
        $this->assertTrue($this->validate(["max-area", 10000]));
        $this->assertTrue($this->validate(["max-area", 1234]));
    }

    public function test_invalid_max_area(): void {
        $this->assertFalse($this->validate(["max-area", -1]));
        $this->assertFalse($this->validate(["max-area", 0.1]));
        $this->assertFalse($this->validate(["max-area", 10001]));
    }

    public function test_valid_contracts_success(): void {
        $this->assertTrue($this->validate(["contracts", null]));
        $this->assertTrue($this->validate(["contracts", ["Sale"]]));
        $this->assertTrue($this->validate(["contracts", ["Rent"]]));
        $this->assertTrue($this->validate(["contracts", ["Sale", "Rent"]]));
    }

    public function test_invalid_contracts_failure(): void {
        $this->assertFalse($this->validate(["contracts", "Sale"]));
        $this->assertFalse($this->validate(["contracts", ["Saled"]]));
    }

    public function test_valid_min_date(): void {
        $this->assertFalse($this->validate(["min-date", "1999-06-15"]));
        $this->assertFalse($this->validate(["min-date", "2024-13-15"]));
        $this->assertFalse($this->validate(["min-date", "2024-06-32"]));
        $this->assertFalse($this->validate(["min-date", "1999-13-32"]));
    }

    public function test_invalid_min_date(): void {
        $this->assertFalse($this->validate(["min-date", "1999-06-15"]));
        $this->assertFalse($this->validate(["min-date", "2024-13-15"]));
        $this->assertFalse($this->validate(["min-date", "2024-06-32"]));
        $this->assertFalse($this->validate(["min-date", "1999-13-32"]));
    }
    public function test_valid_max_date(): void {
        $this->assertFalse($this->validate(["max-date", "1999-06-15"]));
        $this->assertFalse($this->validate(["max-date", "2024-13-15"]));
        $this->assertFalse($this->validate(["max-date", "2024-06-32"]));
        $this->assertFalse($this->validate(["max-date", "1999-13-32"]));
    }

    public function test_invalid_max_date(): void {
        $this->assertFalse($this->validate(["max-date", "1999-06-15"]));
        $this->assertFalse($this->validate(["max-date", "2024-13-15"]));
        $this->assertFalse($this->validate(["max-date", "2024-06-32"]));
        $this->assertFalse($this->validate(["max-date", "1999-13-32"]));
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
