import { fixupConfigRules, fixupPluginRules } from "@eslint/compat";
import typescriptEslint from "@typescript-eslint/eslint-plugin";
import _import from "eslint-plugin-import";
import parser from "vue-eslint-parser";
import path from "node:path";
import { fileURLToPath } from "node:url";
import js from "@eslint/js";
import { FlatCompat } from "@eslint/eslintrc";

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const compat = new FlatCompat({
    baseDirectory: __dirname,
    recommendedConfig: js.configs.recommended,
    allConfig: js.configs.all
});

export default [{
    ignores: ["**/*.cjs", "**/vite.config.ts"],
}, ...fixupConfigRules(compat.extends(
    "plugin:@typescript-eslint/stylistic-type-checked",
    "plugin:vue/vue3-recommended",
    "plugin:import/recommended",
)), {
    plugins: {
        "@typescript-eslint": fixupPluginRules(typescriptEslint),
        import: fixupPluginRules(_import),
    },

    languageOptions: {
        parser: parser,
        ecmaVersion: 5,
        sourceType: "script",

        parserOptions: {
            parser: "@typescript-eslint/parser",
            project: "tsconfig.json",
            extraFileExtensions: [".vue"],
        },
    },

    settings: {
        "import/resolver": {
            typescript: {},
        },
    },

    rules: {
        "import/no-unresolved": "error",

        "import/order": ["error", {
            groups: [["external", "builtin"], "internal", ["sibling"]],

            pathGroups: [{
                pattern: "vue",
                group: "external",
                position: "before",
            }],

            pathGroupsExcludedImportTypes: ["vue"],
            "newlines-between": "never",

            alphabetize: {
                order: "asc",
                caseInsensitive: true,
            },

            distinctGroup: false,
        }],

        semi: ["error", "never"],

        "vue/block-lang": ["error", {
            script: {
                lang: "ts",
            },
        }],

        "vue/block-order": ["error", {
            order: ["template", "script", "style"],
        }],

        "vue/component-api-style": ["error"],
        "vue/define-emits-declaration": ["error"],
        "vue/define-macros-order": ["error"],
        "vue/define-props-declaration": ["error"],
        "vue/html-indent": ["error", 4],
        "vue/multi-word-component-names": ["off"],
        "vue/next-tick-style": ["error", "promise"],
        "vue/no-bare-strings-in-template": ["error"],
        "vue/no-boolean-default": ["error"],
        "vue/no-deprecated-model-definition": ["error"],
        "vue/no-multiple-objects-in-class": ["error"],
        "vue/no-required-prop-with-default": ["error"],
        "vue/no-template-target-blank": ["error"],
        "vue/no-v-html": ["off"],
        "vue/padding-line-between-blocks": ["error", "always"],
        "vue/prefer-true-attribute-shorthand": ["error", "always"],

        "vue/require-macro-variable-name": ["error", {
            defineProps: "props",
            defineEmits: "emit",
        }],

        "vue/require-typed-object-prop": ["error"],
        "vue/require-typed-ref": ["error"],
        "vue/v-for-delimiter-style": ["error", "in"],
        "vue/v-if-else-key": ["error"],
        "vue/v-on-handler-style": ["error"],
        "vue/valid-define-options": ["error"],
    },
}];