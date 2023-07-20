<?php
require_once("Database.php");
    class Tax extends Database {
        private $id;
        private $name;
        private $tax;


        public function getId() {
            return $this->id;
        }

        public function getName() {
            return $this->name;
        }

        public function getTax() {
            return $this->tax;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setName($name) {
            $this->name = $name;
        }

        public function setTax($tax) {
            $this->tax = $tax;
        }

        public function getAllTaxes() {
            $query = "SELECT * FROM tax_rates";

            $this->DBConnect();
            $taxes = $this->fetchAll($query);
            $taxesObjects = [];
            foreach ($taxes as $tax) {
                $taxObject = new Tax();
                $taxObject->setId($tax['id']);
                $taxObject->setName($tax['name']);
                $taxObject->setTax($tax['tax']);

                $taxesObjects[] = $taxObject;
            }
            return $taxesObjects;
        }


    }
?>