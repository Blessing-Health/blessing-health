import { uid } from "quasar";

export class AppFile {
  constructor(data = {}) {
    this.id = data.id;
    this.uuid = data.uuid || uid();
    this.filename = data.filename || data.name;
    this.size = data.size || 0;
    this.mime = data.mime_type || data.type;
    this.collection = data.collection_name;
    this.customProperties = data.custom_properties || {};
    this.createdAt = dayjs(data.created_at);
    this.updatedAt = dayjs(data.updated_at);

    //Locally selected file (if any) to be uploaded
    this.file = data instanceof File ? data : undefined; //setting to null means delete the file
  }
}
