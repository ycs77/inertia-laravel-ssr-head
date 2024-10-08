import { Options, defineConfig } from 'tsup'

export default defineConfig({
  entry: ['src/index.ts', 'src/vue2.ts', 'src/vue3.ts'],
  format: ['cjs', 'esm'],
  outExtension: ({ format }) => ({
    js: format === 'esm' ? '.mjs' : '.cjs',
  }),
  external: ['@inertiajs/core', 'vue'],
  dts: true,
})
