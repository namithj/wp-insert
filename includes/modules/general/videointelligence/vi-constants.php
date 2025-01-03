<?php
function wp_insert_vi_get_constant_fonts() {
	return [
		[
			'text'  => 'Select font family',
			'value' => 'select',
		],
		[
			'text'  => 'Georgia',
			'value' => 'Georgia',
		],
		[
			'text'  => 'Palatino Linotype',
			'value' => 'Palatino Linotype',
		],
		[
			'text'  => 'Times New Roman',
			'value' => 'Times New Roman',
		],
		[
			'text'  => 'Arial',
			'value' => 'Arial',
		],
		[
			'text'  => 'Arial Black',
			'value' => 'Arial Black',
		],
		[
			'text'  => 'Comic Sans MS',
			'value' => 'Comic Sans MS',
		],
		[
			'text'  => 'Impact',
			'value' => 'Impact',
		],
		[
			'text'  => 'Lucida Sans Unicode',
			'value' => 'Lucida Sans Unicode',
		],
		[
			'text'  => 'Tahoma',
			'value' => 'Tahoma',
		],
		[
			'text'  => 'Trebuchet MS',
			'value' => 'Trebuchet MS',
		],
		[
			'text'  => 'Verdana',
			'value' => 'Verdana',
		],
		[
			'text'  => 'Courier New',
			'value' => 'Courier New',
		],
		[
			'text'  => 'Lucida Console',
			'value' => 'Lucida Console',
		],
	];
}

function wp_insert_vi_get_constant_font_sizes() {
	return [
		[
			'text'  => 'Select',
			'value' => 'select',
		],
		[
			'text'  => '8px',
			'value' => '8',
		],
		[
			'text'  => '9px',
			'value' => '9',
		],
		[
			'text'  => '10px',
			'value' => '10',
		],
		[
			'text'  => '11px',
			'value' => '11',
		],
		[
			'text'  => '12px',
			'value' => '12',
		],
		[
			'text'  => '14px',
			'value' => '14',
		],
		[
			'text'  => '16px',
			'value' => '16',
		],
		[
			'text'  => '18px',
			'value' => '18',
		],
		[
			'text'  => '20px',
			'value' => '20',
		],
		[
			'text'  => '22px',
			'value' => '22',
		],
		[
			'text'  => '24px',
			'value' => '24',
		],
		[
			'text'  => '26px',
			'value' => '26',
		],
		[
			'text'  => '28px',
			'value' => '28',
		],
		[
			'text'  => '36px',
			'value' => '36',
		],
	];
}

function wp_insert_vi_get_constant_iab_parent_categories() {
	return [
		[
			'text'  => 'Select tier 1 category',
			'value' => 'select',
		],
		[
			'text'  => 'Arts & Entertainment',
			'value' => 'IAB1',
		],
		[
			'text'  => 'Automotive',
			'value' => 'IAB2',
		],
		[
			'text'  => 'Business',
			'value' => 'IAB3',
		],
		[
			'text'  => 'Careers',
			'value' => 'IAB4',
		],
		[
			'text'  => 'Education',
			'value' => 'IAB5',
		],
		[
			'text'  => 'Family & Parenting',
			'value' => 'IAB6',
		],
		[
			'text'  => 'Health & Fitness',
			'value' => 'IAB7',
		],
		[
			'text'  => 'Food & Drink',
			'value' => 'IAB8',
		],
		[
			'text'  => 'Hobbies & Interests',
			'value' => 'IAB9',
		],
		[
			'text'  => 'Home & Garden',
			'value' => 'IAB10',
		],
		[
			'text'  => 'Law, Gov’t & Politics',
			'value' => 'IAB11',
		],
		[
			'text'  => 'News',
			'value' => 'IAB12',
		],
		[
			'text'  => 'Personal Finance',
			'value' => 'IAB13',
		],
		[
			'text'  => 'Society',
			'value' => 'IAB14',
		],
		[
			'text'  => 'Science',
			'value' => 'IAB15',
		],
		[
			'text'  => 'Pets',
			'value' => 'IAB16',
		],
		[
			'text'  => 'Sports',
			'value' => 'IAB17',
		],
		[
			'text'  => 'Style & Fashion',
			'value' => 'IAB18',
		],
		[
			'text'  => 'Technology & Computing',
			'value' => 'IAB19',
		],
		[
			'text'  => 'Travel',
			'value' => 'IAB20',
		],
		[
			'text'  => 'Real Estate',
			'value' => 'IAB21',
		],
		[
			'text'  => 'Shopping',
			'value' => 'IAB22',
		],
		[
			'text'  => 'Religion & Spirituality',
			'value' => 'IAB23',
		],
		[
			'text'  => 'Uncategorized',
			'value' => 'IAB24',
		],
		[
			'text'  => 'Non-Standard Content',
			'value' => 'IAB25',
		],
		[
			'text'  => 'Illegal Content',
			'value' => 'IAB26',
		],
	];
}

function wp_insert_vi_get_constant_iab_child_categories() {
	return [
		[
			'text'  => 'Select tier 2 category',
			'value' => 'select',
		],
		[
			'text'     => 'Books & Literature',
			'value'    => 'IAB1-1',
			'metadata' => [ 'parent' => 'IAB1' ],
		],
		[
			'text'     => 'Celebrity Fan/Gossip',
			'value'    => 'IAB1-2',
			'metadata' => [ 'parent' => 'IAB1' ],
		],
		[
			'text'     => 'Fine Art',
			'value'    => 'IAB1-3',
			'metadata' => [ 'parent' => 'IAB1' ],
		],
		[
			'text'     => 'Humor',
			'value'    => 'IAB1-4',
			'metadata' => [ 'parent' => 'IAB1' ],
		],
		[
			'text'     => 'Movies',
			'value'    => 'IAB1-5',
			'metadata' => [ 'parent' => 'IAB1' ],
		],
		[
			'text'     => 'Music',
			'value'    => 'IAB1-6',
			'metadata' => [ 'parent' => 'IAB1' ],
		],
		[
			'text'     => 'Television',
			'value'    => 'IAB1-7',
			'metadata' => [ 'parent' => 'IAB1' ],
		],
		[
			'text'     => 'Auto Parts',
			'value'    => 'IAB2-1',
			'metadata' => [ 'parent' => 'IAB2' ],
		],
		[
			'text'     => 'Auto Repair',
			'value'    => 'IAB2-2',
			'metadata' => [ 'parent' => 'IAB2' ],
		],
		[
			'text'     => 'Buying/Selling Cars',
			'value'    => 'IAB2-3',
			'metadata' => [ 'parent' => 'IAB2' ],
		],
		[
			'text'     => 'Car Culture',
			'value'    => 'IAB2-4',
			'metadata' => [ 'parent' => 'IAB2' ],
		],
		[
			'text'     => 'Certified Pre-Owned',
			'value'    => 'IAB2-5',
			'metadata' => [ 'parent' => 'IAB2' ],
		],
		[
			'text'     => 'Convertible',
			'value'    => 'IAB2-6',
			'metadata' => [ 'parent' => 'IAB2' ],
		],
		[
			'text'     => 'Coupe',
			'value'    => 'IAB2-7',
			'metadata' => [ 'parent' => 'IAB2' ],
		],
		[
			'text'     => 'Crossover',
			'value'    => 'IAB2-8',
			'metadata' => [ 'parent' => 'IAB2' ],
		],
		[
			'text'     => 'Diesel',
			'value'    => 'IAB2-9',
			'metadata' => [ 'parent' => 'IAB2' ],
		],
		[
			'text'     => 'Electric Vehicle',
			'value'    => 'IAB2-10',
			'metadata' => [ 'parent' => 'IAB2' ],
		],
		[
			'text'     => 'Hatchback',
			'value'    => 'IAB2-11',
			'metadata' => [ 'parent' => 'IAB2' ],
		],
		[
			'text'     => 'Hybrid',
			'value'    => 'IAB2-12',
			'metadata' => [ 'parent' => 'IAB2' ],
		],
		[
			'text'     => 'Luxury',
			'value'    => 'IAB2-13',
			'metadata' => [ 'parent' => 'IAB2' ],
		],
		[
			'text'     => 'MiniVan',
			'value'    => 'IAB2-14',
			'metadata' => [ 'parent' => 'IAB2' ],
		],
		[
			'text'     => 'Mororcycles',
			'value'    => 'IAB2-15',
			'metadata' => [ 'parent' => 'IAB2' ],
		],
		[
			'text'     => 'Off-Road Vehicles',
			'value'    => 'IAB2-16',
			'metadata' => [ 'parent' => 'IAB2' ],
		],
		[
			'text'     => 'Performance Vehicles',
			'value'    => 'IAB2-17',
			'metadata' => [ 'parent' => 'IAB2' ],
		],
		[
			'text'     => 'Pickup',
			'value'    => 'IAB2-18',
			'metadata' => [ 'parent' => 'IAB2' ],
		],
		[
			'text'     => 'Road-Side Assistance',
			'value'    => 'IAB2-19',
			'metadata' => [ 'parent' => 'IAB2' ],
		],
		[
			'text'     => 'Sedan',
			'value'    => 'IAB2-20',
			'metadata' => [ 'parent' => 'IAB2' ],
		],
		[
			'text'     => 'Trucks & Accessories',
			'value'    => 'IAB2-21',
			'metadata' => [ 'parent' => 'IAB2' ],
		],
		[
			'text'     => 'Vintage Cars',
			'value'    => 'IAB2-22',
			'metadata' => [ 'parent' => 'IAB2' ],
		],
		[
			'text'     => 'Wagon',
			'value'    => 'IAB2-23',
			'metadata' => [ 'parent' => 'IAB2' ],
		],
		[
			'text'     => 'Advertising',
			'value'    => 'IAB3-1',
			'metadata' => [ 'parent' => 'IAB3' ],
		],
		[
			'text'     => 'Agriculture',
			'value'    => 'IAB3-2',
			'metadata' => [ 'parent' => 'IAB3' ],
		],
		[
			'text'     => 'Biotech/Biomedical',
			'value'    => 'IAB3-3',
			'metadata' => [ 'parent' => 'IAB3' ],
		],
		[
			'text'     => 'Business Software',
			'value'    => 'IAB3-4',
			'metadata' => [ 'parent' => 'IAB3' ],
		],
		[
			'text'     => 'Construction',
			'value'    => 'IAB3-5',
			'metadata' => [ 'parent' => 'IAB3' ],
		],
		[
			'text'     => 'Forestry',
			'value'    => 'IAB3-6',
			'metadata' => [ 'parent' => 'IAB3' ],
		],
		[
			'text'     => 'Government',
			'value'    => 'IAB3-7',
			'metadata' => [ 'parent' => 'IAB3' ],
		],
		[
			'text'     => 'Green Solutions',
			'value'    => 'IAB3-8',
			'metadata' => [ 'parent' => 'IAB3' ],
		],
		[
			'text'     => 'Human Resources',
			'value'    => 'IAB3-9',
			'metadata' => [ 'parent' => 'IAB3' ],
		],
		[
			'text'     => 'Logistics',
			'value'    => 'IAB3-10',
			'metadata' => [ 'parent' => 'IAB3' ],
		],
		[
			'text'     => 'Marketing',
			'value'    => 'IAB3-11',
			'metadata' => [ 'parent' => 'IAB3' ],
		],
		[
			'text'     => 'Metals',
			'value'    => 'IAB3-12',
			'metadata' => [ 'parent' => 'IAB3' ],
		],
		[
			'text'     => 'Career Planning',
			'value'    => 'IAB4-1',
			'metadata' => [ 'parent' => 'IAB4' ],
		],
		[
			'text'     => 'College',
			'value'    => 'IAB4-2',
			'metadata' => [ 'parent' => 'IAB4' ],
		],
		[
			'text'     => 'Financial Aid',
			'value'    => 'IAB4-3',
			'metadata' => [ 'parent' => 'IAB4' ],
		],
		[
			'text'     => 'Job Fairs',
			'value'    => 'IAB4-4',
			'metadata' => [ 'parent' => 'IAB4' ],
		],
		[
			'text'     => 'Job Search',
			'value'    => 'IAB4-5',
			'metadata' => [ 'parent' => 'IAB4' ],
		],
		[
			'text'     => 'Resume Writing/Advice',
			'value'    => 'IAB4-6',
			'metadata' => [ 'parent' => 'IAB4' ],
		],
		[
			'text'     => 'Nursing',
			'value'    => 'IAB4-7',
			'metadata' => [ 'parent' => 'IAB4' ],
		],
		[
			'text'     => 'Scholarships',
			'value'    => 'IAB4-8',
			'metadata' => [ 'parent' => 'IAB4' ],
		],
		[
			'text'     => 'Telecommuting',
			'value'    => 'IAB4-9',
			'metadata' => [ 'parent' => 'IAB4' ],
		],
		[
			'text'     => 'U.S. Military',
			'value'    => 'IAB4-10',
			'metadata' => [ 'parent' => 'IAB4' ],
		],
		[
			'text'     => 'Career Advice',
			'value'    => 'IAB4-11',
			'metadata' => [ 'parent' => 'IAB4' ],
		],
		[
			'text'     => '7-12 Education',
			'value'    => 'IAB5-1',
			'metadata' => [ 'parent' => 'IAB5' ],
		],
		[
			'text'     => 'Adult Education',
			'value'    => 'IAB5-2',
			'metadata' => [ 'parent' => 'IAB5' ],
		],
		[
			'text'     => 'Art History',
			'value'    => 'IAB5-3',
			'metadata' => [ 'parent' => 'IAB5' ],
		],
		[
			'text'     => 'Colledge Administration',
			'value'    => 'IAB5-4',
			'metadata' => [ 'parent' => 'IAB5' ],
		],
		[
			'text'     => 'College Life',
			'value'    => 'IAB5-5',
			'metadata' => [ 'parent' => 'IAB5' ],
		],
		[
			'text'     => 'Distance Learning',
			'value'    => 'IAB5-6',
			'metadata' => [ 'parent' => 'IAB5' ],
		],
		[
			'text'     => 'English as a 2nd Language',
			'value'    => 'IAB5-7',
			'metadata' => [ 'parent' => 'IAB5' ],
		],
		[
			'text'     => 'Language Learning',
			'value'    => 'IAB5-8',
			'metadata' => [ 'parent' => 'IAB5' ],
		],
		[
			'text'     => 'Graduate School',
			'value'    => 'IAB5-9',
			'metadata' => [ 'parent' => 'IAB5' ],
		],
		[
			'text'     => 'Homeschooling',
			'value'    => 'IAB5-10',
			'metadata' => [ 'parent' => 'IAB5' ],
		],
		[
			'text'     => 'Homework/Study Tips',
			'value'    => 'IAB5-11',
			'metadata' => [ 'parent' => 'IAB5' ],
		],
		[
			'text'     => 'K-6 Educators',
			'value'    => 'IAB5-12',
			'metadata' => [ 'parent' => 'IAB5' ],
		],
		[
			'text'     => 'Private School',
			'value'    => 'IAB5-13',
			'metadata' => [ 'parent' => 'IAB5' ],
		],
		[
			'text'     => 'Special Education',
			'value'    => 'IAB5-14',
			'metadata' => [ 'parent' => 'IAB5' ],
		],
		[
			'text'     => 'Studying Business',
			'value'    => 'IAB5-15',
			'metadata' => [ 'parent' => 'IAB5' ],
		],
		[
			'text'     => 'Adoption',
			'value'    => 'IAB6-1',
			'metadata' => [ 'parent' => 'IAB6' ],
		],
		[
			'text'     => 'Babies & Toddlers',
			'value'    => 'IAB6-2',
			'metadata' => [ 'parent' => 'IAB6' ],
		],
		[
			'text'     => 'Daycare/Pre School',
			'value'    => 'IAB6-3',
			'metadata' => [ 'parent' => 'IAB6' ],
		],
		[
			'text'     => 'Family Internet',
			'value'    => 'IAB6-4',
			'metadata' => [ 'parent' => 'IAB6' ],
		],
		[
			'text'     => 'Parenting – K-6 Kids',
			'value'    => 'IAB6-5',
			'metadata' => [ 'parent' => 'IAB6' ],
		],
		[
			'text'     => 'Parenting teens',
			'value'    => 'IAB6-6',
			'metadata' => [ 'parent' => 'IAB6' ],
		],
		[
			'text'     => 'Pregnancy',
			'value'    => 'IAB6-7',
			'metadata' => [ 'parent' => 'IAB6' ],
		],
		[
			'text'     => 'Special Needs Kids',
			'value'    => 'IAB6-8',
			'metadata' => [ 'parent' => 'IAB6' ],
		],
		[
			'text'     => 'Eldercare',
			'value'    => 'IAB6-9',
			'metadata' => [ 'parent' => 'IAB6' ],
		],
		[
			'text'     => 'Exercise',
			'value'    => 'IAB7-1',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'A.D.D.',
			'value'    => 'IAB7-2',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'AIDS/HIV',
			'value'    => 'IAB7-3',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Allergies',
			'value'    => 'IAB7-4',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Alternative Medicine',
			'value'    => 'IAB7-5',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Arthritis',
			'value'    => 'IAB7-6',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Asthma',
			'value'    => 'IAB7-7',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Autism/PDD',
			'value'    => 'IAB7-8',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Bipolar Disorder',
			'value'    => 'IAB7-9',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Brain Tumor',
			'value'    => 'IAB7-10',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Cancer',
			'value'    => 'IAB7-11',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Cholesterol',
			'value'    => 'IAB7-12',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Chronic Fatigue Syndrome',
			'value'    => 'IAB7-13',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Chronic Pain',
			'value'    => 'IAB7-14',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Cold & Flu',
			'value'    => 'IAB7-15',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Deafness',
			'value'    => 'IAB7-16',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Dental Care',
			'value'    => 'IAB7-17',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Depression',
			'value'    => 'IAB7-18',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Dermatology',
			'value'    => 'IAB7-19',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Diabetes',
			'value'    => 'IAB7-20',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Epilepsy',
			'value'    => 'IAB7-21',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'GERD/Acid Reflux',
			'value'    => 'IAB7-22',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Headaches/Migraines',
			'value'    => 'IAB7-23',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Heart Disease',
			'value'    => 'IAB7-24',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Herbs for Health',
			'value'    => 'IAB7-25',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Holistic Healing',
			'value'    => 'IAB7-26',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'IBS/Crohn’s Disease',
			'value'    => 'IAB7-27',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Incest/Abuse Support',
			'value'    => 'IAB7-28',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Incontinence',
			'value'    => 'IAB7-29',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Infertility',
			'value'    => 'IAB7-30',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Men’s Health',
			'value'    => 'IAB7-31',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Nutrition',
			'value'    => 'IAB7-32',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Orthopedics',
			'value'    => 'IAB7-33',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Panic/Anxiety Disorders',
			'value'    => 'IAB7-34',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Pediatrics',
			'value'    => 'IAB7-35',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Physical Therapy',
			'value'    => 'IAB7-36',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Psychology/Psychiatry',
			'value'    => 'IAB7-37',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Senor Health',
			'value'    => 'IAB7-38',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Sexuality',
			'value'    => 'IAB7-39',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Sleep Disorders',
			'value'    => 'IAB7-40',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Smoking Cessation',
			'value'    => 'IAB7-41',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Substance Abuse',
			'value'    => 'IAB7-42',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Thyroid Disease',
			'value'    => 'IAB7-43',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Weight Loss',
			'value'    => 'IAB7-44',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'Women’s Health',
			'value'    => 'IAB7-45',
			'metadata' => [ 'parent' => 'IAB7' ],
		],
		[
			'text'     => 'American Cuisine',
			'value'    => 'IAB8-1',
			'metadata' => [ 'parent' => 'IAB8' ],
		],
		[
			'text'     => 'Barbecues & Grilling',
			'value'    => 'IAB8-2',
			'metadata' => [ 'parent' => 'IAB8' ],
		],
		[
			'text'     => 'Cajun/Creole',
			'value'    => 'IAB8-3',
			'metadata' => [ 'parent' => 'IAB8' ],
		],
		[
			'text'     => 'Chinese Cuisine',
			'value'    => 'IAB8-4',
			'metadata' => [ 'parent' => 'IAB8' ],
		],
		[
			'text'     => 'Cocktails/Beer',
			'value'    => 'IAB8-5',
			'metadata' => [ 'parent' => 'IAB8' ],
		],
		[
			'text'     => 'Coffee/Tea',
			'value'    => 'IAB8-6',
			'metadata' => [ 'parent' => 'IAB8' ],
		],
		[
			'text'     => 'Cuisine-Specific',
			'value'    => 'IAB8-7',
			'metadata' => [ 'parent' => 'IAB8' ],
		],
		[
			'text'     => 'Desserts & Baking',
			'value'    => 'IAB8-8',
			'metadata' => [ 'parent' => 'IAB8' ],
		],
		[
			'text'     => 'Dining Out',
			'value'    => 'IAB8-9',
			'metadata' => [ 'parent' => 'IAB8' ],
		],
		[
			'text'     => 'Food Allergies',
			'value'    => 'IAB8-10',
			'metadata' => [ 'parent' => 'IAB8' ],
		],
		[
			'text'     => 'French Cuisine',
			'value'    => 'IAB8-11',
			'metadata' => [ 'parent' => 'IAB8' ],
		],
		[
			'text'     => 'Health/Lowfat Cooking',
			'value'    => 'IAB8-12',
			'metadata' => [ 'parent' => 'IAB8' ],
		],
		[
			'text'     => 'Italian Cuisine',
			'value'    => 'IAB8-13',
			'metadata' => [ 'parent' => 'IAB8' ],
		],
		[
			'text'     => 'Japanese Cuisine',
			'value'    => 'IAB8-14',
			'metadata' => [ 'parent' => 'IAB8' ],
		],
		[
			'text'     => 'Mexican Cuisine',
			'value'    => 'IAB8-15',
			'metadata' => [ 'parent' => 'IAB8' ],
		],
		[
			'text'     => 'Vegan',
			'value'    => 'IAB8-16',
			'metadata' => [ 'parent' => 'IAB8' ],
		],
		[
			'text'     => 'Vegetarian',
			'value'    => 'IAB8-17',
			'metadata' => [ 'parent' => 'IAB8' ],
		],
		[
			'text'     => 'Wine',
			'value'    => 'IAB8-18',
			'metadata' => [ 'parent' => 'IAB8' ],
		],
		[
			'text'     => 'Art/Technology',
			'value'    => 'IAB9-1',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Arts & Crafts',
			'value'    => 'IAB9-2',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Beadwork',
			'value'    => 'IAB9-3',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Birdwatching',
			'value'    => 'IAB9-4',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Board Games/Puzzles',
			'value'    => 'IAB9-5',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Candle & Soap Making',
			'value'    => 'IAB9-6',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Card Games',
			'value'    => 'IAB9-7',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Chess',
			'value'    => 'IAB9-8',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Cigars',
			'value'    => 'IAB9-9',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Collecting',
			'value'    => 'IAB9-10',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Comic Books',
			'value'    => 'IAB9-11',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Drawing/Sketching',
			'value'    => 'IAB9-12',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Freelance Writing',
			'value'    => 'IAB9-13',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Genealogy',
			'value'    => 'IAB9-14',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Getting Published',
			'value'    => 'IAB9-15',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Guitar',
			'value'    => 'IAB9-16',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Home Recording',
			'value'    => 'IAB9-17',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Investors & Patents',
			'value'    => 'IAB9-18',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Jewelry Making',
			'value'    => 'IAB9-19',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Magic & Illusion',
			'value'    => 'IAB9-20',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Needlework',
			'value'    => 'IAB9-21',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Painting',
			'value'    => 'IAB9-22',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Photography',
			'value'    => 'IAB9-23',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Radio',
			'value'    => 'IAB9-24',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Roleplaying Games',
			'value'    => 'IAB9-25',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Sci-Fi & Fantasy',
			'value'    => 'IAB9-26',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Scrapbooking',
			'value'    => 'IAB9-27',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Screenwriting',
			'value'    => 'IAB9-28',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Stamps & Coins',
			'value'    => 'IAB9-29',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Video & Computer Games',
			'value'    => 'IAB9-30',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Woodworking',
			'value'    => 'IAB9-31',
			'metadata' => [ 'parent' => 'IAB9' ],
		],
		[
			'text'     => 'Appliances',
			'value'    => 'IAB10-1',
			'metadata' => [ 'parent' => 'IAB10' ],
		],
		[
			'text'     => 'Entertaining',
			'value'    => 'IAB10-2',
			'metadata' => [ 'parent' => 'IAB10' ],
		],
		[
			'text'     => 'Environmental Safety',
			'value'    => 'IAB10-3',
			'metadata' => [ 'parent' => 'IAB10' ],
		],
		[
			'text'     => 'Gardening',
			'value'    => 'IAB10-4',
			'metadata' => [ 'parent' => 'IAB10' ],
		],
		[
			'text'     => 'Home Repair',
			'value'    => 'IAB10-5',
			'metadata' => [ 'parent' => 'IAB10' ],
		],
		[
			'text'     => 'Home Theater',
			'value'    => 'IAB10-6',
			'metadata' => [ 'parent' => 'IAB10' ],
		],
		[
			'text'     => 'Interior Decorating',
			'value'    => 'IAB10-7',
			'metadata' => [ 'parent' => 'IAB10' ],
		],
		[
			'text'     => 'Landscaping',
			'value'    => 'IAB10-8',
			'metadata' => [ 'parent' => 'IAB10' ],
		],
		[
			'text'     => 'Remodeling & Construction',
			'value'    => 'IAB10-9',
			'metadata' => [ 'parent' => 'IAB10' ],
		],
		[
			'text'     => 'Immigration',
			'value'    => 'IAB11-1',
			'metadata' => [ 'parent' => 'IAB11' ],
		],
		[
			'text'     => 'Legal Issues',
			'value'    => 'IAB11-2',
			'metadata' => [ 'parent' => 'IAB11' ],
		],
		[
			'text'     => 'U.S. Government Resources',
			'value'    => 'IAB11-3',
			'metadata' => [ 'parent' => 'IAB11' ],
		],
		[
			'text'     => 'Politics',
			'value'    => 'IAB11-4',
			'metadata' => [ 'parent' => 'IAB11' ],
		],
		[
			'text'     => 'Commentary',
			'value'    => 'IAB11-5',
			'metadata' => [ 'parent' => 'IAB11' ],
		],
		[
			'text'     => 'International News',
			'value'    => 'IAB12-1',
			'metadata' => [ 'parent' => 'IAB12' ],
		],
		[
			'text'     => 'National News',
			'value'    => 'IAB12-2',
			'metadata' => [ 'parent' => 'IAB12' ],
		],
		[
			'text'     => 'Local News',
			'value'    => 'IAB12-3',
			'metadata' => [ 'parent' => 'IAB12' ],
		],
		[
			'text'     => 'Beginning Investing',
			'value'    => 'IAB13-1',
			'metadata' => [ 'parent' => 'IAB13' ],
		],
		[
			'text'     => 'Credit/Debt & Loans',
			'value'    => 'IAB13-2',
			'metadata' => [ 'parent' => 'IAB13' ],
		],
		[
			'text'     => 'Financial News',
			'value'    => 'IAB13-3',
			'metadata' => [ 'parent' => 'IAB13' ],
		],
		[
			'text'     => 'Financial Planning',
			'value'    => 'IAB13-4',
			'metadata' => [ 'parent' => 'IAB13' ],
		],
		[
			'text'     => 'Hedge Fund',
			'value'    => 'IAB13-5',
			'metadata' => [ 'parent' => 'IAB13' ],
		],
		[
			'text'     => 'Insurance',
			'value'    => 'IAB13-6',
			'metadata' => [ 'parent' => 'IAB13' ],
		],
		[
			'text'     => 'Investing',
			'value'    => 'IAB13-7',
			'metadata' => [ 'parent' => 'IAB13' ],
		],
		[
			'text'     => 'Mutual Funds',
			'value'    => 'IAB13-8',
			'metadata' => [ 'parent' => 'IAB13' ],
		],
		[
			'text'     => 'Options',
			'value'    => 'IAB13-9',
			'metadata' => [ 'parent' => 'IAB13' ],
		],
		[
			'text'     => 'Retirement Planning',
			'value'    => 'IAB13-10',
			'metadata' => [ 'parent' => 'IAB13' ],
		],
		[
			'text'     => 'Stocks',
			'value'    => 'IAB13-11',
			'metadata' => [ 'parent' => 'IAB13' ],
		],
		[
			'text'     => 'Tax Planning',
			'value'    => 'IAB13-12',
			'metadata' => [ 'parent' => 'IAB13' ],
		],
		[
			'text'     => 'Dating',
			'value'    => 'IAB14-1',
			'metadata' => [ 'parent' => 'IAB14' ],
		],
		[
			'text'     => 'Divorce Support',
			'value'    => 'IAB14-2',
			'metadata' => [ 'parent' => 'IAB14' ],
		],
		[
			'text'     => 'Gay Life',
			'value'    => 'IAB14-3',
			'metadata' => [ 'parent' => 'IAB14' ],
		],
		[
			'text'     => 'Marriage',
			'value'    => 'IAB14-4',
			'metadata' => [ 'parent' => 'IAB14' ],
		],
		[
			'text'     => 'Senior Living',
			'value'    => 'IAB14-5',
			'metadata' => [ 'parent' => 'IAB14' ],
		],
		[
			'text'     => 'Teens',
			'value'    => 'IAB14-6',
			'metadata' => [ 'parent' => 'IAB14' ],
		],
		[
			'text'     => 'Weddings',
			'value'    => 'IAB14-7',
			'metadata' => [ 'parent' => 'IAB14' ],
		],
		[
			'text'     => 'Ethnic Specific',
			'value'    => 'IAB14-8',
			'metadata' => [ 'parent' => 'IAB14' ],
		],
		[
			'text'     => 'Astrology',
			'value'    => 'IAB15-1',
			'metadata' => [ 'parent' => 'IAB15' ],
		],
		[
			'text'     => 'Biology',
			'value'    => 'IAB15-2',
			'metadata' => [ 'parent' => 'IAB15' ],
		],
		[
			'text'     => 'Chemistry',
			'value'    => 'IAB15-3',
			'metadata' => [ 'parent' => 'IAB15' ],
		],
		[
			'text'     => 'Geology',
			'value'    => 'IAB15-4',
			'metadata' => [ 'parent' => 'IAB15' ],
		],
		[
			'text'     => 'Paranormal Phenomena',
			'value'    => 'IAB15-5',
			'metadata' => [ 'parent' => 'IAB15' ],
		],
		[
			'text'     => 'Physics',
			'value'    => 'IAB15-6',
			'metadata' => [ 'parent' => 'IAB15' ],
		],
		[
			'text'     => 'Space/Astronomy',
			'value'    => 'IAB15-7',
			'metadata' => [ 'parent' => 'IAB15' ],
		],
		[
			'text'     => 'Geography',
			'value'    => 'IAB15-8',
			'metadata' => [ 'parent' => 'IAB15' ],
		],
		[
			'text'     => 'Botany',
			'value'    => 'IAB15-9',
			'metadata' => [ 'parent' => 'IAB15' ],
		],
		[
			'text'     => 'Weather',
			'value'    => 'IAB15-10',
			'metadata' => [ 'parent' => 'IAB15' ],
		],
		[
			'text'     => 'Aquariums',
			'value'    => 'IAB16-1',
			'metadata' => [ 'parent' => 'IAB16' ],
		],
		[
			'text'     => 'Birds',
			'value'    => 'IAB16-2',
			'metadata' => [ 'parent' => 'IAB16' ],
		],
		[
			'text'     => 'Cats',
			'value'    => 'IAB16-3',
			'metadata' => [ 'parent' => 'IAB16' ],
		],
		[
			'text'     => 'Dogs',
			'value'    => 'IAB16-4',
			'metadata' => [ 'parent' => 'IAB16' ],
		],
		[
			'text'     => 'Large Animals',
			'value'    => 'IAB16-5',
			'metadata' => [ 'parent' => 'IAB16' ],
		],
		[
			'text'     => 'Reptiles',
			'value'    => 'IAB16-6',
			'metadata' => [ 'parent' => 'IAB16' ],
		],
		[
			'text'     => 'Veterinary Medicine',
			'value'    => 'IAB16-7',
			'metadata' => [ 'parent' => 'IAB16' ],
		],
		[
			'text'     => 'Auto Racing',
			'value'    => 'IAB17-1',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Baseball',
			'value'    => 'IAB17-2',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Bicycling',
			'value'    => 'IAB17-3',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Bodybuilding',
			'value'    => 'IAB17-4',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Boxing',
			'value'    => 'IAB17-5',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Canoeing/Kayaking',
			'value'    => 'IAB17-6',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Cheerleading',
			'value'    => 'IAB17-7',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Climbing',
			'value'    => 'IAB17-8',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Cricket',
			'value'    => 'IAB17-9',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Figure Skating',
			'value'    => 'IAB17-10',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Fly Fishing',
			'value'    => 'IAB17-11',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Football',
			'value'    => 'IAB17-12',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Freshwater Fishing',
			'value'    => 'IAB17-13',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Game & Fish',
			'value'    => 'IAB17-14',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Golf',
			'value'    => 'IAB17-15',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Horse Racing',
			'value'    => 'IAB17-16',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Horses',
			'value'    => 'IAB17-17',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Hunting/Shooting',
			'value'    => 'IAB17-18',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Inline Skating',
			'value'    => 'IAB17-19',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Martial Arts',
			'value'    => 'IAB17-20',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Mountain Biking',
			'value'    => 'IAB17-21',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'NASCAR Racing',
			'value'    => 'IAB17-22',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Olympics',
			'value'    => 'IAB17-23',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Paintball',
			'value'    => 'IAB17-24',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Power & Motorcycles',
			'value'    => 'IAB17-25',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Pro Basketball',
			'value'    => 'IAB17-26',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Pro Ice Hockey',
			'value'    => 'IAB17-27',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Rodeo',
			'value'    => 'IAB17-28',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Rugby',
			'value'    => 'IAB17-29',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Running/Jogging',
			'value'    => 'IAB17-30',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Sailing',
			'value'    => 'IAB17-31',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Saltwater Fishing',
			'value'    => 'IAB17-32',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Scuba Diving',
			'value'    => 'IAB17-33',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Skateboarding',
			'value'    => 'IAB17-34',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Skiing',
			'value'    => 'IAB17-35',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Snowboarding',
			'value'    => 'IAB17-36',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Surfing/Bodyboarding',
			'value'    => 'IAB17-37',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Swimming',
			'value'    => 'IAB17-38',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Table Tennis/Ping-Pong',
			'value'    => 'IAB17-39',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Tennis',
			'value'    => 'IAB17-40',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Volleyball',
			'value'    => 'IAB17-41',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Walking',
			'value'    => 'IAB17-42',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Waterski/Wakeboard',
			'value'    => 'IAB17-43',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'World Soccer',
			'value'    => 'IAB17-44',
			'metadata' => [ 'parent' => 'IAB17' ],
		],
		[
			'text'     => 'Beauty',
			'value'    => 'IAB18-1',
			'metadata' => [ 'parent' => 'IAB18' ],
		],
		[
			'text'     => 'Body Art',
			'value'    => 'IAB18-2',
			'metadata' => [ 'parent' => 'IAB18' ],
		],
		[
			'text'     => 'Fashion',
			'value'    => 'IAB18-3',
			'metadata' => [ 'parent' => 'IAB18' ],
		],
		[
			'text'     => 'Jewelry',
			'value'    => 'IAB18-4',
			'metadata' => [ 'parent' => 'IAB18' ],
		],
		[
			'text'     => 'Clothing',
			'value'    => 'IAB18-5',
			'metadata' => [ 'parent' => 'IAB18' ],
		],
		[
			'text'     => 'Accessories',
			'value'    => 'IAB18-6',
			'metadata' => [ 'parent' => 'IAB18' ],
		],
		[
			'text'     => '3-D Graphics',
			'value'    => 'IAB19-1',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Animation',
			'value'    => 'IAB19-2',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Antivirus Software',
			'value'    => 'IAB19-3',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'C/C++',
			'value'    => 'IAB19-4',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Cameras & Camcorders',
			'value'    => 'IAB19-5',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Cell Phones',
			'value'    => 'IAB19-6',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Computer Certification',
			'value'    => 'IAB19-7',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Computer Networking',
			'value'    => 'IAB19-8',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Computer Peripherals',
			'value'    => 'IAB19-9',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Computer Reviews',
			'value'    => 'IAB19-10',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Data Centers',
			'value'    => 'IAB19-11',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Databases',
			'value'    => 'IAB19-12',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Desktop Publishing',
			'value'    => 'IAB19-13',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Desktop Video',
			'value'    => 'IAB19-14',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Email',
			'value'    => 'IAB19-15',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Graphics Software',
			'value'    => 'IAB19-16',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Home Video/DVD',
			'value'    => 'IAB19-17',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Internet Technology',
			'value'    => 'IAB19-18',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Java',
			'value'    => 'IAB19-19',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'JavaScript',
			'value'    => 'IAB19-20',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Mac Support',
			'value'    => 'IAB19-21',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'MP3/MIDI',
			'value'    => 'IAB19-22',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Net Conferencing',
			'value'    => 'IAB19-23',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Net for Beginners',
			'value'    => 'IAB19-24',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Network Security',
			'value'    => 'IAB19-25',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Palmtops/PDAs',
			'value'    => 'IAB19-26',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'PC Support',
			'value'    => 'IAB19-27',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Portable',
			'value'    => 'IAB19-28',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Entertainment',
			'value'    => 'IAB19-29',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Shareware/Freeware',
			'value'    => 'IAB19-30',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Unix',
			'value'    => 'IAB19-31',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Visual Basic',
			'value'    => 'IAB19-32',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Web Clip Art',
			'value'    => 'IAB19-33',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Web Design/HTML',
			'value'    => 'IAB19-34',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Web Search',
			'value'    => 'IAB19-35',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Windows',
			'value'    => 'IAB19-36',
			'metadata' => [ 'parent' => 'IAB19' ],
		],
		[
			'text'     => 'Adventure Travel',
			'value'    => 'IAB20-1',
			'metadata' => [ 'parent' => 'IAB20' ],
		],
		[
			'text'     => 'Africa',
			'value'    => 'IAB20-2',
			'metadata' => [ 'parent' => 'IAB20' ],
		],
		[
			'text'     => 'Air Travel',
			'value'    => 'IAB20-3',
			'metadata' => [ 'parent' => 'IAB20' ],
		],
		[
			'text'     => 'Australia & New Zealand',
			'value'    => 'IAB20-4',
			'metadata' => [ 'parent' => 'IAB20' ],
		],
		[
			'text'     => 'Bed & Breakfasts',
			'value'    => 'IAB20-5',
			'metadata' => [ 'parent' => 'IAB20' ],
		],
		[
			'text'     => 'Budget Travel',
			'value'    => 'IAB20-6',
			'metadata' => [ 'parent' => 'IAB20' ],
		],
		[
			'text'     => 'Business Travel',
			'value'    => 'IAB20-7',
			'metadata' => [ 'parent' => 'IAB20' ],
		],
		[
			'text'     => 'By US Locale',
			'value'    => 'IAB20-8',
			'metadata' => [ 'parent' => 'IAB20' ],
		],
		[
			'text'     => 'Camping',
			'value'    => 'IAB20-9',
			'metadata' => [ 'parent' => 'IAB20' ],
		],
		[
			'text'     => 'Canada',
			'value'    => 'IAB20-10',
			'metadata' => [ 'parent' => 'IAB20' ],
		],
		[
			'text'     => 'Caribbean',
			'value'    => 'IAB20-11',
			'metadata' => [ 'parent' => 'IAB20' ],
		],
		[
			'text'     => 'Cruises',
			'value'    => 'IAB20-12',
			'metadata' => [ 'parent' => 'IAB20' ],
		],
		[
			'text'     => 'Eastern Europe',
			'value'    => 'IAB20-13',
			'metadata' => [ 'parent' => 'IAB20' ],
		],
		[
			'text'     => 'Europe',
			'value'    => 'IAB20-14',
			'metadata' => [ 'parent' => 'IAB20' ],
		],
		[
			'text'     => 'France',
			'value'    => 'IAB20-15',
			'metadata' => [ 'parent' => 'IAB20' ],
		],
		[
			'text'     => 'Greece',
			'value'    => 'IAB20-16',
			'metadata' => [ 'parent' => 'IAB20' ],
		],
		[
			'text'     => 'Honeymoons/Getaways',
			'value'    => 'IAB20-17',
			'metadata' => [ 'parent' => 'IAB20' ],
		],
		[
			'text'     => 'Hotels',
			'value'    => 'IAB20-18',
			'metadata' => [ 'parent' => 'IAB20' ],
		],
		[
			'text'     => 'Italy',
			'value'    => 'IAB20-19',
			'metadata' => [ 'parent' => 'IAB20' ],
		],
		[
			'text'     => 'Japan',
			'value'    => 'IAB20-20',
			'metadata' => [ 'parent' => 'IAB20' ],
		],
		[
			'text'     => 'Mexico & Central America',
			'value'    => 'IAB20-21',
			'metadata' => [ 'parent' => 'IAB20' ],
		],
		[
			'text'     => 'National Parks',
			'value'    => 'IAB20-22',
			'metadata' => [ 'parent' => 'IAB20' ],
		],
		[
			'text'     => 'South America',
			'value'    => 'IAB20-23',
			'metadata' => [ 'parent' => 'IAB20' ],
		],
		[
			'text'     => 'Spas',
			'value'    => 'IAB20-24',
			'metadata' => [ 'parent' => 'IAB20' ],
		],
		[
			'text'     => 'Theme Parks',
			'value'    => 'IAB20-25',
			'metadata' => [ 'parent' => 'IAB20' ],
		],
		[
			'text'     => 'Traveling with Kids',
			'value'    => 'IAB20-26',
			'metadata' => [ 'parent' => 'IAB20' ],
		],
		[
			'text'     => 'United Kingdom',
			'value'    => 'IAB20-27',
			'metadata' => [ 'parent' => 'IAB20' ],
		],
		[
			'text'     => 'Apartments',
			'value'    => 'IAB21-1',
			'metadata' => [ 'parent' => 'IAB21' ],
		],
		[
			'text'     => 'Architects',
			'value'    => 'IAB21-2',
			'metadata' => [ 'parent' => 'IAB21' ],
		],
		[
			'text'     => 'Buying/Selling Homes',
			'value'    => 'IAB21-3',
			'metadata' => [ 'parent' => 'IAB21' ],
		],
		[
			'text'     => 'Contests & Freebies',
			'value'    => 'IAB22-1',
			'metadata' => [ 'parent' => 'IAB22' ],
		],
		[
			'text'     => 'Couponing',
			'value'    => 'IAB22-2',
			'metadata' => [ 'parent' => 'IAB22' ],
		],
		[
			'text'     => 'Comparison',
			'value'    => 'IAB22-3',
			'metadata' => [ 'parent' => 'IAB22' ],
		],
		[
			'text'     => 'Engines',
			'value'    => 'IAB22-4',
			'metadata' => [ 'parent' => 'IAB22' ],
		],
		[
			'text'     => 'Alternative Religions',
			'value'    => 'IAB23-1',
			'metadata' => [ 'parent' => 'IAB23' ],
		],
		[
			'text'     => 'Atheism/Agnosticism',
			'value'    => 'IAB23-2',
			'metadata' => [ 'parent' => 'IAB23' ],
		],
		[
			'text'     => 'Buddhism',
			'value'    => 'IAB23-3',
			'metadata' => [ 'parent' => 'IAB23' ],
		],
		[
			'text'     => 'Catholicism',
			'value'    => 'IAB23-4',
			'metadata' => [ 'parent' => 'IAB23' ],
		],
		[
			'text'     => 'Christianity',
			'value'    => 'IAB23-5',
			'metadata' => [ 'parent' => 'IAB23' ],
		],
		[
			'text'     => 'Hinduism',
			'value'    => 'IAB23-6',
			'metadata' => [ 'parent' => 'IAB23' ],
		],
		[
			'text'     => 'Islam',
			'value'    => 'IAB23-7',
			'metadata' => [ 'parent' => 'IAB23' ],
		],
		[
			'text'     => 'Judaism',
			'value'    => 'IAB23-8',
			'metadata' => [ 'parent' => 'IAB23' ],
		],
		[
			'text'     => 'Latter-Day Saints',
			'value'    => 'IAB23-9',
			'metadata' => [ 'parent' => 'IAB23' ],
		],
		[
			'text'     => 'Pagan/Wiccan',
			'value'    => 'IAB23-10',
			'metadata' => [ 'parent' => 'IAB23' ],
		],
		[
			'text'     => 'Unmoderated UGC',
			'value'    => 'IAB25-1',
			'metadata' => [ 'parent' => 'IAB25' ],
		],
		[
			'text'     => 'Extreme Graphic/Explicit Violence',
			'value'    => 'IAB25-2',
			'metadata' => [ 'parent' => 'IAB25' ],
		],
		[
			'text'     => 'Pornography',
			'value'    => 'IAB25-3',
			'metadata' => [ 'parent' => 'IAB25' ],
		],
		[
			'text'     => 'Profane Content',
			'value'    => 'IAB25-4',
			'metadata' => [ 'parent' => 'IAB25' ],
		],
		[
			'text'     => 'Hate Content',
			'value'    => 'IAB25-5',
			'metadata' => [ 'parent' => 'IAB25' ],
		],
		[
			'text'     => 'Under Construction',
			'value'    => 'IAB25-6',
			'metadata' => [ 'parent' => 'IAB25' ],
		],
		[
			'text'     => 'Incentivized',
			'value'    => 'IAB25-7',
			'metadata' => [ 'parent' => 'IAB25' ],
		],
		[
			'text'     => 'Illegal Content',
			'value'    => 'IAB26-1',
			'metadata' => [ 'parent' => 'IAB26' ],
		],
		[
			'text'     => 'Warez',
			'value'    => 'IAB26-2',
			'metadata' => [ 'parent' => 'IAB26' ],
		],
		[
			'text'     => 'Spyware/Malware',
			'value'    => 'IAB26-3',
			'metadata' => [ 'parent' => 'IAB26' ],
		],
		[
			'text'     => 'Copyright Infringement',
			'value'    => 'IAB26-4',
			'metadata' => [ 'parent' => 'IAB26' ],
		],
	];
}
