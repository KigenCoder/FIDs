<?php

	namespace App\Http\Requests;

	use Illuminate\Foundation\Http\FormRequest;

	class ExportRequest extends FormRequest {
		/**
		 * Determine if the user is authorized to make this request.
		 *
		 * @return bool
		 */
		public function authorize() {
			return true;
		}

		/**
		 * Get the validation rules that apply to the request.
		 *
		 * @return array
		 */
		public function rules() {
			return [
				'startMonth' => 'required',
				'startYear' => 'required|numeric',
				//'marketType' => 'required',
				//'endYear' => 'gte:startYear',


			];
		}

		/**
		 * Get the error messages for the defined validation rules.
		 *
		 * @return array
		 */
		public function messages() {
			return [
				'startMonth.required' => 'Please select month',
				'startYear.required' => 'Please select year',
				//'marketType.required' => 'Please select market type',
				//'endYear.gte'=>'End year must be greater or equal to start year',
			];
		}
	}
