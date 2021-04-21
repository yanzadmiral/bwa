module.exports = (sequelize, DataTypes) => {
  const User = sequelize.define(
    "User",
    {
      id: {
        type: DataTypes.INTEGER,
        primaryKey: true,
        autoIncrement: true,
        allowNull: false,
      },
      name: {
        type: DataTypes.STRING,
        allowNul: false,
      },
      email: {
        type: DataTypes.STRING,
        allowNul: false,
        unique: true,
      },
      password: {
        type: DataTypes.STRING,
        allowNul: false,
      },
      role: {
        type: DataTypes.ENUM,
        values: ["student", "admin"],
        allowNul: false,
        defaultValue: "student",
      },
      avatar: {
        type: DataTypes.STRING,
        allowNul: true,
      },
      profession: {
        type: DataTypes.STRING,
        allowNul: true,
      },
      createdAt: {
        field: "created_at",
        type: DataTypes.DATE,
        allowNul: false,
      },
      updatedAt: {
        field: "updated_at",
        type: DataTypes.DATE,
        allowNul: false,
      },
    },
    {
      tableName: "users",
      tamestaps: true,
    }
  );
  return User;
};
