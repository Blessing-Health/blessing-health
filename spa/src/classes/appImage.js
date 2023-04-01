import { AppFile } from "src/classes/appFile";
export class AppImage extends AppFile {
  constructor(data = {}) {
    super(data);
    this.filename = data.file_name || "photo-placeholder.png";
    this.width = get(data.custom_properties, "width", 0);
    this.height = get(data.custom_properties, "height", 0);
    this.isImage = true;
    this.rotationClass = "";
    this.source = data.source;
  }
}
