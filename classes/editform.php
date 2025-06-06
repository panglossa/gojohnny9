<?php
class TEditForm extends TForm {
	var $type = 'form';
	var $submitlabel = 'Save';
	var $button = null;
	var $fields = [];
    
    function fields($items = []) {
        $this->fields = $items;
        return $this;
        }
	
	function getcontent() {
        $res = parent::getcontent();
		$tbl = gj('table');
		foreach($this->fields as $field) {
            if (!isset($field['type'])) {
                $field['type'] = 'edit';
                }
            if (!isset($field['label'])) {
                $field['label'] = $field['id'];
                }
			switch ($field['type']) {
				case 'select':
				case 'lisbox':
				case 'combobox':
					$input = gj($field['type'])->id($field['id']);
                    if (isset($field['content'])) {
                        foreach($field['content'] as $key => $label) {
                            $input->add($key, $label);
                            }
                        }
					break;
				default: 
					$input = gj($field['type'], (isset($field['content'])?$field['content']:''))->id($field['id']);
					break;
				}
			if (isset($field['placeholder'])) {
                $input->placeholder($field['placeholder']);
                }
			$tbl->add($field['label'], $input);
			}
		$res = $tbl . BR . $res;
		return $res;
		}
	}
    