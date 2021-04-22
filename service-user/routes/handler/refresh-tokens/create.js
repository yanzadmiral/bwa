const { User, RefreshTokens } = require("../../../models");
const Validator = require("fastest-validator");
const v = new Validator();

module.exports = async (req, res) => {
  const userId = req.body.user_id;
  const refreshTokens = req.body.refresh_token;
  const schema = {
    refresh_token: "string",
    user_id: "number",
  };

  const validate = v.validate(req.body, schema);

  if (validate.length) {
    return res.status(400).json({
      status: "error",
      message: validate,
    });
  }
  const user = await User.findByPk(userId);
  if (!user) {
    return res.status(400).json({
      status: "error",
      message: "user not found",
    });
  }
  const createRefreshToken = await RefreshTokens.create({
    token: refreshTokens,
    user_id: userId,
  });

  return res.json({
    status: "success",
    data: createRefreshToken,
  });
};
