const apiAdapter = require("../../apiAdapter");

const { URL_SERVICE_COURSE } = process.env;

const api = apiAdapter(URL_SERVICE_COURSE);

module.exports = async (req, res) => {
  try {
    const userId = req.user.data.id;

    const mycourses = await api.get("/my-courses", {
      params:{user_id: userId}
    });
    return res.json(mycourses.data);
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
