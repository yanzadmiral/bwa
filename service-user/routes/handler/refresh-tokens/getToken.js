const { User, RefreshTokens } = require("../../../models");
const Validator = require("fastest-validator");
const v = new Validator();

module.exports = async (req, res) => {
  const torefreshtoken = req.query.refresh_token;

  if (!torefreshtoken) {
    return res.status(400).json({
      status: "error",
      message: "token nof found",
    });
  }

  const token = await RefreshTokens.findOne({
    where: { token: torefreshtoken },
  });

  if (!token) {
    return res.status(400).json({
      status: "error",
      message: "invalid token",
    });
  }

  return res.json({
    status: "success",
    token,
  });
};
