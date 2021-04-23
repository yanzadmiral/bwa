const apiAdapter = require("../../apiAdapter");
const jwt = require("jsonwebtoken");

const {
  URL_SERVICE_USER,
  JWT_SECRET,
  JWT_SECRET_REFRESH_TOKEN,
  JWT_ACCESS_TOKEN_EXPIRED,
  JWT_REFRESH_TOKEN_EXPIRED,
} = process.env;

const api = apiAdapter(URL_SERVICE_USER);

module.exports = async (req, res) => {
  try {
    const refreshtokens = req.body.refresh_token;
    const email = req.body.email;

    if (!refreshtokens || !email) {
      return res.status(400).json({
        status: "error",
        message: "invalid token",
      });
    }
    await api.get("/refreshtokens", {
      params: { refresh_token: refreshtokens },
    });
    jwt.verify(refreshtokens, JWT_SECRET_REFRESH_TOKEN, (err, decode) => {
      if (err) {
        return res.status(403).json({
          status: "error",
          message: err.message,
        });
      }
      if (email !== decode.data.email) {
        return res.status(400).json({
          status: "error",
          message: "email is not valid",
        });
      }
  
      const token = jwt.sign({data:decode.data},JWT_SECRET,{expiresIn:JWT_ACCESS_TOKEN_EXPIRED});
      return res.json({
          status:"success",
          data:{
              token
          }
      })
    });
  } catch (error) {
    if (error.code == "ECONNREFUSED") {
      return res.status(500).json({
        status: "error",
        message: "Service Unavailable",
      });
    }
    const { status, data } = error.response;
    return res.status(status).json(data);
  }
};
