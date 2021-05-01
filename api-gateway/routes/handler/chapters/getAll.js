const apiAdapter = require("../../apiAdapter");

const { URL_SERVICE_COURSE,HOSTNAME } = process.env;

const api = apiAdapter(URL_SERVICE_COURSE);

module.exports = async (req, res) => {
  try {
    const courses = await api.get("/courses",{
        params :{
            ...req.query
        }
    });

    const firstPage = courses.data.data.first_page_url.split('?').pop();
    const lastPage = courses.data.data.last_page_url.split('?').pop();
    courses.data.data.last_page_url = `${HOSTNAME}/courses?`+lastPage;
    courses.data.data.first_page_url = `${HOSTNAME}/courses?`+firstPage;

    if (courses.data.data.next_page_url) {
        const nextPage = courses.data.data.next_page_url.split('?').pop();
        courses.data.data.next_page_url = `${HOSTNAME}/courses?`+nextPage;
    }
    if (courses.data.data.prev_page_url) {
        const prevPage = courses.data.data.prev_page_url.split('?').pop();
        courses.data.data.prev_page_url = `${HOSTNAME}/courses?`+prevPage;
    }

    courses.data.data.path = `${HOSTNAME}/courses`;
    return res.json(courses.data);
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
