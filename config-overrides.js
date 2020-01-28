const {
  override,
  disableEsLint,
  overrideDevServer,
  addDecoratorsLegacy,
  watchAll
} = require("customize-cra");

module.exports = {
  webpack: override(
    // usual webpack plugin
    disableEsLint(),
    addDecoratorsLegacy()
  ),
  devServer: overrideDevServer(
    // dev server plugin
    watchAll()
  )
};