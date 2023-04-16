import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { CategoryService } from 'src/app/services/category.service';
import { MediaService } from 'src/app/services/media.service';
import { RivistaService } from 'src/app/services/rivista.service';

@Component({
  selector: 'app-update-rivista',
  templateUrl: './update-rivista.component.html',
  styleUrls: ['./update-rivista.component.scss'],
})
export class UpdateRivistaComponent implements OnInit {
  rivista: any = {};
  categories: any;

  constructor(
    private categoryService: CategoryService,
    private rivistaService: RivistaService,
    private mediaService: MediaService,
    private router: Router,
    private route: ActivatedRoute
  ) {}

  ngOnInit(): void {
    let slug = this.route.snapshot.paramMap.get('slug');

    if (slug) {
      this.categoryService.all().subscribe((response: any) => {
        this.categories = response.data;
      });

      this.rivistaService.get(slug).subscribe((response: any) => {
        this.rivista = response.data;
      });
    } else {
      this.router.navigateByUrl('/');
    }
  }

  updateRivista = (): void => {
    this.rivistaService.update(this.rivista).subscribe((response: any) => {
      if (this.rivista.image && !this.isImageLink())
        this.mediaService.uploadImage(response.data.id, this.rivista.image).subscribe({
          complete: () => { 
            this.router.navigateByUrl('/rivistas/' + response.data.slug);
          }
        })
      else this.router.navigateByUrl('/rivistas/' + response.data.slug);
    });
  };

  deleteImage() {
    this.mediaService.deleteImage(this.rivista.id).subscribe(() => {
      this.rivista.image = null;
    });
  }

  isImageLink() {
    return typeof this.rivista.image == 'string'
  }
}
