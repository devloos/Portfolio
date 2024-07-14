<?php

namespace App\Controller\Api;

use App\Entity\Project;
use App\Service\ProjectService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ProjectController extends AbstractController
{
    #[Route('/api/project/list', name: 'Project List')]
    public function list(Request $request, ProjectService $projectService): JsonResponse
    {
        $response = new JsonResponse();

        $include = [];
        $criteria = [];
        $orderBy = null;
        $limit = null;
        $offset = null;

        if ($request->query->has('include')) {
            $include = $request->query->all('include');
        }

        if ($request->query->has('featured') && $request->query->getBoolean('featured')) {
            $criteria = ['featured' => true];
        }

        if ($request->query->has('orderBy')) {
            $orderBy = $request->query->all('orderBy');
        }

        if ($request->query->has('limit')) {
            $limit = $request->query->getInt('limit');
        }

        if ($request->query->has('offset')) {
            $offset = $request->query->getInt('offset');
        }

        $data = $projectService->getProjects($include, $criteria, $orderBy, $limit, $offset);

        $response->setData([
            'projects' => $data,
            'message' => 'Query was successful.',
            'success' => true,
        ]);

        return $response;
    }

    #[Route('/api/project/get/{id}', name: 'Project Get')]
    public function get(Request $request, Project $project): JsonResponse
    {
        $response = new JsonResponse();

        $response->setData([
            'project' => $project->toArray(),
            'message' => 'Query was successful.',
            'success' => true,
        ]);

        return $response;
    }
}
