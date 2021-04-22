const { User, RefreshTokens } = require("../../../models");

module.exports = async (req, res) => {
  const userid = req.body.user_id;

  const user = await User.findByPk(userid);

  if (!user) {
    return res.status(404).json({
      status: "error",
      message: "user not found",
    });
  }

  await RefreshTokens.destroy({
    where: { user_id: userid },
  });

  return res.json({
    status: "success",
    message: "refresh token deleted",
  });
};
