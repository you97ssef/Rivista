import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class MediaService {
  private api = environment.apiUrl;

  constructor(private http: HttpClient) {}

  uploadRivistaImage(id: string, image: any) {
    const form = new FormData();
    form.append('image', image);
    form.append('rivista', id);
    return this.http.post(`${this.api}/media/rivistas`, form);
  }

  deleteRivistaImage(id: string) {
    return this.http.delete(`${this.api}/media/rivistas/${id}`, {});
  }

  uploadProfileImage(image: any) {
    const form = new FormData();
    form.append('image', image);
    return this.http.post(`${this.api}/media/profile`, form);
  }
}
