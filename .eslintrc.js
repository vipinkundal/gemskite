module.exports = {
	rules: {
		// we should always disable console logs and debugging in production
		'vue/require-prop-types': 0,
		'vue/prop-name-casing': 0,
		'indent': ['error', 'tab'],
		'quotes': ['error', 'single'],
		'semi': ['error', 'always'],
		'eqeqeq': ['error', 'always'],
	},
	globals: {
		'$event': true,
	},
	parser: 'vue-eslint-parser',
	extends: [
		// These four options are more or less levels of strictness, give the above URL a read through and decide how strict you want your linting to be
		//   Also note we're not setting this up with general JS linting here, just .vue linting
		// 'plugin:vue/base',
		//'plugin:vue/essential',
		// 'plugin:vue/strongly-recommended',
		//'plugin:vue/base',
		//'plugin:vue/vue3-essential',
		'plugin:vue/vue3-recommended'
		//'plugin:vue/recommended',
	],
};
