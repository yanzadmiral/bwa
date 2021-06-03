require("dotenv").config();
const express = require("express");
const path = require("path");
const cookieParser = require("cookie-parser");
const logger = require("morgan");

const indexRouter = require("./routes/index");
const usersRouter = require("./routes/users");
const coursesRouter = require("./routes/courses");
const mediaRouter = require("./routes/media");
const ordersRouter = require("./routes/ordersPayment");
const paymentsRouter = require("./routes/payments");
const chaptersRouter = require("./routes/chapters");
const lessonsRouter = require("./routes/lessons");
const refreshTokensRouter = require("./routes/refreshTokens");
const verifyToken = require("./middleware/verifyToken");
const MentorsRouter = require("./routes/mentors");
const ImageCoursesRouter = require("./routes/imageCourses");
const MyCoursesRouter = require("./routes/myCourses");
const ReviewsRouter = require("./routes/reviews");
const WebhookRouter = require("./routes/webhook");

const can = require("./middleware/permission");

const app = express();

app.use(logger("dev"));
app.use(express.json({ limit: "50mb" }));
app.use(express.urlencoded({ extended: false, limit: "50mb" }));
app.use(cookieParser());
app.use(express.static(path.join(__dirname, "public")));

app.use("/", indexRouter);
app.use("/users", usersRouter);
app.use("/courses", coursesRouter);
app.use("/media", verifyToken, can("admin", "student"), mediaRouter);
app.use("/orders", verifyToken, can("admin", "student"), ordersRouter);
app.use("/payments", paymentsRouter);
app.use("/lessons", verifyToken, can("admin"), lessonsRouter);
app.use("/chapters", verifyToken, can("admin"), chaptersRouter);
app.use("/refresh-tokens", refreshTokensRouter);
app.use("/mentors", verifyToken, can("admin"), MentorsRouter);
app.use("/image-courses", verifyToken, can("admin"), ImageCoursesRouter);
app.use("/my-courses", verifyToken, can("admin", "student"), MyCoursesRouter);
app.use("/reviews", verifyToken, can("admin", "student"), ReviewsRouter);
app.use("/webhook", WebhookRouter);

module.exports = app;
