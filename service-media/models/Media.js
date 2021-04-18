module.exports = (sequelize, DataTypes) => {
  const Media = sequelize.define(
    "Media",
    {
      id: {
        type: DataTypes.INTEGER,
        primaryKey: true,
        autoIncrement: true,
        allowNull: false,
      },
      image: {
        type: DataTypes.STRING,
        allowNul: false,
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
      tableName: "media",
    }
  );
  return Media;
};
