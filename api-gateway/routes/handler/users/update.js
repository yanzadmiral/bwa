const apiAdapter = require("../../apiAdapter");
const jwt = require("jsonwebtoken");

const { URL_SERVICE_USER } = process.env;

const api = apiAdapter(URL_SERVICE_USER);

module.exports = async (req, res) => {
  try {
    const id = req.user.data.id;
    const user = await api.put(`/users/${id}`, req.body);
    return res.json(user.data);
  } catch (error) {
    //console.log(error);
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
